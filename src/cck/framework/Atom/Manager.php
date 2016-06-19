<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    CCK
 * @license    Proprietary http://jbzoo.com/license
 * @copyright  Copyright (C) JBZoo.com,  All rights reserved.
 * @link       http://jbzoo.com
 */

namespace JBZoo\CCK\Atom;

use JBZoo\CCK\Container;
use JBZoo\Data\Data;
use JBZoo\Data\PHPArray;
use JBZoo\Utils\Filter;
use JBZoo\Utils\FS;
use JBZoo\Utils\Sys;

/**
 * Class Manager
 * @package JBZoo\CCK
 */
class Manager extends Container
{
    /**
     * @var array
     */
    protected $_paths = [];

    /**
     * @var PHPArray[]
     */
    protected $_atomsInfo = [];

    /**
     * @param string $paths
     */
    public function addPath($paths)
    {
        $this->app['path']->set('atoms', $paths);
    }

    /**
     * Load meta information from atom by name pattern (glob)
     *
     * @param $names
     * @return bool
     */
    public function load($names)
    {
        $path = 'atoms:' . strtolower($names) . '/atom.php';

        $result = [];
        if ($manifests = $this->app['path']->glob($path)) {
            foreach ($manifests as $initFile) {
                $atomId = $this->_getIdFromPath($initFile);

                if (isset($this->_atomsInfo[$atomId])) {
                    $result[$atomId] = $this->_atomsInfo[$atomId];

                } else {
                    $this->app->trigger("atom.load.{$names}.before");

                    if ($info = $this->_registerAtom($initFile)) {
                        $result[$atomId] = $this->_atomsInfo[$atomId] = $info;

                        if (Sys::isFunc($info['load'])) {
                            $info['load']($this->app);
                        }
                    }

                    $this->app->trigger("atom.load.{$names}.after");
                }
            }

            return $result;
        }

        return false;
    }

    /**
     * @param string $names
     * @return bool
     */
    public function init($names)
    {
        $names = strtolower($names);
        $path  = 'atoms:' . $names . '/atom.php';

        if ($manifests = $this->app['path']->glob($path)) {
            foreach ($manifests as $initFile) {
                $atomId = $this->_getIdFromPath($initFile);
                $this[$atomId]; // Only init via Container ArrayAccess feature!
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($id)
    {
        if (!$this->offsetExists($id)) {
            $this[$id] = $this->_getInitCallback($id);
        }

        return parent::offsetGet($id);
    }

    /**
     * Register callback in atom manager that call init function in atom
     *
     * @param $atomId
     * @return \Closure
     */
    protected function _getInitCallback($atomId)
    {
        $app = $this->app;

        if (!isset($this->_atomsInfo[$atomId]) && !$this->load($atomId)) {
            $app->error('Atom "' . $atomId . '" not found and can\'t be loaded.');

        } elseif (!isset($this->_atomsInfo[$atomId])) {
            $app->error('Atom "' . $atomId . '" not found.');
        }

        /** @var Data $atomInfo */
        $atomInfo = $this->_atomsInfo[$atomId];

        $callback = function () use ($app, $atomInfo, $atomId) {

            $nsPart    = Filter::className($atomId);
            $atomClass = implode('\\', ['JBZoo', 'CCK', 'Atom', $nsPart, $nsPart]);

            $app->trigger("atom.init.{$atomId}.before");

            if (class_exists($atomClass)) {
                /** @var Atom $result */
                $result = new $atomClass($atomId, $atomInfo);
                $result->init($app);
            } else {
                $result = new AtomDefault($atomId, $atomInfo);
                $result->init($app);
            }

            $app->trigger("atom.init.{$atomId}.after");

            return $result;
        };

        return $callback;
    }

    /**
     * @param string $initFile
     * @param bool   $isOverload
     * @return PHPArray[]
     * @throws \JBZoo\Path\Exception
     */
    protected function _registerAtom($initFile, $isOverload = false)
    {
        $atomId = $this->_getIdFromPath($initFile);

        if ($isOverload) {
            $this->_atomsInfo[$atomId] = new PHPArray($initFile);

        } elseif (!isset($this->_atomsInfo[$atomId])) {
            $this->_atomsInfo[$atomId] = new PHPArray($initFile);
        }

        if (isset($this->_atomsInfo[$atomId])) { // Only if we need it

            $dir = FS::dirname($initFile);
            $this->app['path']->set('atom-' . $atomId, $dir);
            $namespace = $this->app->addLoadPath(['Atom', $atomId], $dir);

            $this->_atomsInfo[$atomId]->set('dir', $dir);
            $this->_atomsInfo[$atomId]->set('namespace', $namespace);

            return $this->_atomsInfo[$atomId];
        }
    }

    /**
     * @param $initFile
     * @return string
     */
    protected function _getIdFromPath($initFile)
    {
        $result = FS::dirname($initFile);
        $result = FS::filename($result);
        $result = strtolower($result);

        return $result;
    }
}
