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

namespace JBZoo\CCK;

use JBZoo\CCK\Atom\Atom;
use JBZoo\CCK\Exception\Exception;
use JBZoo\CCK\Atom\Manager as AtomManager;
use JBZoo\CCK\Element\Manager as ElementManager;
use JBZoo\CCK\Table\Manager as TableManager;
use JBZoo\CCK\Type\Manager as TypeManager;
use JBZoo\Assets\Manager as AssetsManager;
use JBZoo\CrossCMS\AbstractEvents;
use JBZoo\CrossCMS\Cms;
use JBZoo\Utils\Filter;
use JBZoo\PimpleDumper\PimpleDumper;

/**
 * Class Application
 * @package JBZoo\CCK
 */
class App extends Cms
{
    /**
     * @return App
     */
    public static function getInstance()
    {
        static $instance;

        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Init application
     */
    public function init()
    {
        static $isInit;
        if ($isInit) {
            return false;
        }

        $isInit = true;

        $this->trigger('init.app.before');

        // Composer autoload
        $this['loader'] = function () {
            return \ComposerAutoloaderInit_JBZoo::getLoader();
        };

        // Init Atom Manager
        $this['atoms'] = function () {
            $atomManager = new AtomManager();
            $atomManager->addPath('jbzoo:atoms');

            return $atomManager;
        };

        // Init Model Manager
        $this['models'] = function () {
            return new TableManager();
        };

        // Init Element Manager
        $this['elements'] = function () {
            return new ElementManager();
        };

        // Init Type Manager
        $this['types'] = function () {
            return new TypeManager();
        };

        $this->on(AbstractEvents::EVENT_SHUTDOWN, function (App $app) {
            if (class_exists('\JBZoo\PimpleDumper\PimpleDumper')) {
                $dumper = new PimpleDumper();
                $dumper->setRoot(dirname(__FILE__) . '/../../..'); // Real root
                $dumper->dumpPimple($app, true);
            }
        });

        $this->_initPaths();
        $this->_initAssets();
        $this->_initAtoms();
        $this->_initAliases();

        $this->trigger('init.app.after');
    }

    /**
     * Trigger all event listners
     *
     * @param  string $event
     * @param  array  $arguments
     * @return int
     */
    public function trigger($event, array $arguments = array())
    {
        if (strpos($event, '*') === false) {
            //$this->mark($event); // Super profiler!
            return parent::trigger($event, $arguments);
        }

        return 0;
    }

    /**
     * Show fatal error page
     *
     * @param string $message
     * @param bool   $addPrefix
     */
    public function error($message = 'Internal Server Error', $addPrefix = true)
    {
        $message = $addPrefix ? 'JBZoo Error #500: ' . $message : $message;
        $this['response']->set500($message);
    }

    /**
     * Show not found page
     *
     * @param string $message
     * @param bool   $addPrefix
     */
    public function show404($message = 'Not found', $addPrefix = true)
    {
        $message = $addPrefix ? 'JBZoo Error #404: ' . $message : $message;
        $this['response']->set404($message);
    }

    /**
     * Set profiler mark
     *
     * @param string $label
     */
    public function mark($label)
    {
        if (class_exists('\JBDump')) { // Hack for correct system init
            \JBDump::mark($label);
        }
    }

    /**
     * Add path for composer autoload
     *
     * @param string $prefix
     * @param string $paths
     *
     * @return array|string
     */
    public function addLoadPath($prefix, $paths)
    {
        $prefix = array_map(function ($item) {
            return Filter::className($item);
        }, (array)$prefix);

        $prefix = array_merge(['JBZoo', 'CCK'], (array)$prefix);
        $prefix = implode('\\', $prefix) . '\\';

        if ($this['path']->isVirtual($paths)) {
            $paths = $this['path']->glob($paths);
        }

        if ($paths) {
            $this['loader']->addPsr4($prefix, $paths);
        }

        return $prefix;
    }

    /**
     * Find current Atom, Controller, and Action. And execute them!
     *
     * @param string $act
     * @return mixed|null
     * @throws Exception
     */
    public function execute($act)
    {
        $this->trigger('app.exec.before', func_get_args());

        if (!$act) {
            throw new Exception('Act is not defined!');
        }

        // Get current atom and controller
        //$act = $act ?: $this['request']->get('act', 'core.index.index');
        list($atomName, $controller, $action) = Filter::_($act, function ($orginal) {
            $value  = Filter::cmd($orginal);
            $values = explode('.', $value);

            $atom   = isset($values[0]) ? $values[0] : 'core';
            $ctrl   = isset($values[1]) ? $values[1] : 'index';
            $action = isset($values[2]) ? $values[2] : 'index';

            return [$atom, $ctrl, $action];
        });

        /** @var Atom $atom */
        $atom   = $this['atoms'][$atomName];
        $result = $atom->execute($controller, $action);

        $this->trigger('app.exec.after', [$atomName, $controller, $action, $result]);

        return $result;
    }

    /**
     * Return current state of debug config
     *
     * @return bool
     */
    public function isDebug()
    {
        return $this['config']->isDebug();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($id)
    {
        if (strpos($id, '.') !== false && !isset($this[$id])) {
            list($atom, $helper) = explode('.', Filter::cmd($id), 2);

            if (!isset($this['atoms'][$atom])) {
                throw new Exception('Undefined atom "' . $atom . '"');
            }

            if (!isset($this['atoms'][$atom][$helper])) {
                //throw new Exception('Undefined atom helper "' . $atom . ':' . $helper . '"');
            }

            $this[$id] = function ($app) use ($atom, $helper) {
                return $app['atoms'][$atom][$helper];
            };

            return $this[$id];
        }

        return parent::offsetGet($id);
    }

    /**
     * Init general paths for JBZoo
     * @throws \JBZoo\Path\Exception
     */
    protected function _initPaths()
    {
        // Extend init for CrossCMS paths
        $this['path'] = $this->extend('path', function ($path) {
            $path->set('jbzoo', 'root:' . JBZOO_PATH);
            return $path;
        });

        $paths = [
            'elements' => 'jbzoo:elements',
            'models'   => 'jbzoo:models',
            'assets'   => 'jbzoo:assets',
            'js'       => 'assets:js',
            'css'      => 'assets:css',
            'less'     => 'assets:less',
            'img'      => 'assets:img',
        ];

        foreach ($paths as $pathId => $pathValue) {
            $this['path']->set($pathId, $pathValue);
        }

        $this->trigger('init.paths');
    }

    /**
     * Init assets helper
     */
    protected function _initAssets()
    {
        $app = $this;

        $this['assets'] = function () use ($app) {

            $manager = new AssetsManager($app['path'], [
                'debug' => $app->isDebug(),
                'less'  => [
                    'cache_path' => $app['path']->get('cache:') . '/jbzoo_less',
                ],
            ]);

            return $manager;
        };
    }

    /**
     * Load and init core atoms
     */
    protected function _initAtoms()
    {
        /** @var AtomManager $aManager */
        $aManager = $this['atoms'];

        // Define important classes
        $aManager->load('*');

        // Init core
        $aManager->init('core');
        $aManager->init('core-*');
        $aManager->init('assets');

        $this->trigger('init.atoms');
    }

    /**
     * Create aliases
     */
    protected function _initAliases()
    {
        $this['route'] = function () {
            return $this['atoms']['core']['route'];
        };

        $this['dbg'] = function () {
            return $this['atoms']['core']['debug'];
        };

        $this['cfg'] = function () {
            return $this['atoms']['core']['config'];
        };
    }

    /**
     * Check request
     */
    public function checkRequest()
    {
        $this->trigger('request');

        if ($this['request']->isAjax()) {
            $this->trigger('request.ajax');
        }
    }
}
