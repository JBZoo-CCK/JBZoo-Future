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
    protected $_atoms = [];

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
    public function loadInfo($names)
    {
        $names = strtolower($names);
        $path  = 'atoms:' . $names . '/atom.php';

        $result = [];
        if ($manifests = $this->app['path']->glob($path)) {
            foreach ($manifests as $initFile) {
                $this->app->trigger("atom.loadinfo.before");
                if ($names != '*') {
                    $this->app->trigger("atom.loadinfo.{$names}.before");
                }

                if ($info = $this->_registerAtom($initFile)) {
                    $result[$this->_getIdFromPath($initFile)] = $info;
                }

                if ($names != '*') {
                    $this->app->trigger("atom.loadinfo.{$names}.after");
                }

                $this->app->trigger("atom.loadinfo.after");
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

        if (!isset($this->_atoms[$atomId]) && !$this->loadInfo($atomId)) {
            $app->error('Atom "' . $atomId . '" not found and can\'t be loaded.');

        } elseif (!isset($this->_atoms[$atomId])) {
            $app->error('Atom "' . $atomId . '" not found.');
        }

        /** @var Data $atomInfo */
        $atomInfo = $this->_atoms[$atomId];

        $callback = function () use ($app, $atomInfo, $atomId) {

            $nsPart    = Filter::className($atomId);
            $atomClass = implode('\\', ['JBZoo', 'CCK', 'Atom', $nsPart, $nsPart]);

            $app->trigger("atom.init.before");
            $app->trigger("atom.init.{$atomId}.before");

            if (class_exists($atomClass)) {
                /** @var Atom $atom */
                $result = new $atomClass($atomId, $atomInfo);
                $result->init($app);
            } else {
                $result = new AtomDefault($atomId, $atomInfo);
                $result->init($app);
            }

            $app->trigger("atom.init.{$atomId}.after");
            $app->trigger('atom.init.after');

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
            $this->_atoms[$atomId] = new PHPArray($initFile);

        } elseif (!isset($this->_atoms[$atomId])) {
            $this->_atoms[$atomId] = new PHPArray($initFile);
        }

        if (isset($this->_atoms[$atomId])) { // Only if we need it

            $dir = FS::dirname($initFile);
            $this->_atoms[$atomId]->set('dir', $dir);
            $this->app['path']->set('atom-' . $atomId, $dir);
            $this->app->addLoadPath(['Atom', $atomId], $dir);

            return $this->_atoms[$atomId];
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
