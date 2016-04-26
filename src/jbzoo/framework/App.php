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
            parent::trigger($event, $arguments);
        }

        return 0;
    }

    /**
     * Show fatal error page
     *
     * @param string $message
     *
     * @codeCoverageIgnore
     */
    public function error($message = 'Internal Server Error')
    {
        $this['response']->set500('JBZoo Error #500: ' . $message);
    }

    /**
     * Show not found page
     *
     * @param string $message
     *
     * @codeCoverageIgnore
     */
    public function show404($message = 'Not found')
    {
        $this['response']->set404('JBZoo Error #404: ' . $message);
    }

    /**
     * Set profiler mark
     *
     * @param string $label
     *
     * @codeCoverageIgnore
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
    }

    /**
     * Find current Atom, Controller, and Action. And execute them!
     *
     * @param string $controller
     * @param string $action
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute($controller = null, $action = null)
    {
        $this->trigger('app.exec.before', func_get_args());

        // Get current atom and controller
        $controller = $controller ?: $this['request']->get('ctrl', 'core.index');
        list($atomName, $controller) = Filter::_($controller, function ($orginal) {
            $value = Filter::cmd($orginal);

            $values = explode('.', $value);
            if (count($values) === 1) {
                $values[] = 'index';
            }

            if (count($values) !== 2) {
                App::getInstance()->error('No valid controller: ' . $orginal);
            }

            $atom = $values[0] ?: 'core';
            $ctrl = $values[1] ?: 'index';

            return [$atom, $ctrl];
        });

        // Get current action
        $action = $action ?: $this['request']->get('task', 'index');
        $action = Filter::_($action, function ($orginal) {
            $value  = Filter::cmd($orginal);
            $action = $value ?: 'index';
            return $action;
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
            $path->set('jbzoo', 'root:' . JBZOO_EXT_PATH);
            return $path;
        });

        // Assets
        $this['path']->set('assets', 'jbzoo:assets');
        $this['path']->set('js', 'assets:js');
        $this['path']->set('css', 'assets:css');
        $this['path']->set('less', 'assets:less');
        $this['path']->set('img', 'assets:img');

        // Helpers
        $this['path']->set('framework', 'jbzoo:framework');
        //$this['path']->set('helpers', 'framework:helpers');
        //$this['path']->set('helpers', 'atoms:*/helpers');

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
        /** @var AtomManager $atomManager */
        $atomManager = $this['atoms'];

        // Define important classes
        $atomManager->loadInfo('core');
        $atomManager->loadInfo('core-*');

        // Register assets' dependencies
        $atomManager->init('assets');
        $atomManager->init('assets-*');

        $this->trigger('init.atoms');
    }

    /**
     * Load and init core atoms
     */
    protected function _initAliases()
    {
        $this['route'] = function () {
            return $this['atoms']['core']['route'];
        };

        $this['dbg'] = function () {
            return $this['atoms']['core']['debug'];
        };
    }
}
