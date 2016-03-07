<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CCK
 * @license   Proprietary http://jbzoo.com/license
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      http://jbzoo.com
 */

namespace JBZoo\CCK;

use JBZoo\CCK\Atom\Atom;
use JBZoo\CCK\Atom\Manager as AtomManager;
use JBZoo\Assets\Manager as AssetsManager;
use JBZoo\Assets\Factory as AssetsFactory;
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

        if (!$isInit) {

            $this->trigger('init.app.before');

            $this['atoms'] = function () {
                $atomManager = new AtomManager();
                $atomManager->addPath('jbzoo:atoms');

                return $atomManager;
            };

            // Extend init for CrossCMS paths
            $this['path'] = $this->extend('path', function ($path) {
                $path->set('jbzoo', __DIR__ . '/..');

                $component = $path->get('root:administrator/components/com_jbzoo');

                $component = realpath($component);
                //dump($component);

                $path->setRoot($component);

                return $path;
            });

            $this->on('cms.shutdown', function (App $app) {
                if (class_exists('\JBZoo\PimpleDumper\PimpleDumper')) {
                    $dumper = new PimpleDumper();
                    $dumper->dumpPimple($app, true);
                    $dumper->dumpPhpstorm($app);

                    $app->mark('pimple.dumper');
                }
            });

            $this->_initPaths();
            $this->_initAssets();
            $this->_initAtoms();

            $this->trigger('init.app.after');

            $isInit = true;
        }
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
        $this->mark($event);

        return parent::trigger($event, $arguments);
    }

    /**
     * Show fatal error page
     * @param string $message
     */
    public function error($message = 'Internal Server Error')
    {
        $this['response']->set500('JBZoo Error #500: ' . $message);
    }

    /**
     * Show not found page
     * @param string $message
     */
    public function show404($message = 'Not found')
    {
        $this['response']->set404('JBZoo Error #404: ' . $message);
    }

    /**
     * Set profiler mark
     * @param string $label
     */
    public function mark($label)
    {
        if (array_key_exists('p', $_GET)) {
            \jbdump::mark($label);
        }
    }

    /**
     * Add path for composer autoload
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
     * Find current Atom. Controller, Action and execute them
     */
    public function execute()
    {
        $this->trigger('app.exec.before');

        // Get current action
        $action = $this['request']->get('action', 'index', function ($orginal) {
            $value  = Filter::cmd($orginal);
            $action = $value ?: 'index';
            return $action;
        });

        // Get current atom and controller
        list($atom, $controller) = $this['request']->get('controller', 'core.index', function ($orginal) {
            $value = Filter::cmd($orginal);

            $values = explode('.', $value);
            if (count($values) !== 2) {
                App::getInstance()->error('No valid controller: ' . $orginal);
            }

            $atom = $values[0] ?: 'core';
            $ctrl = $values[1] ?: 'ndex';

            return [$atom, $ctrl];
        });

        try {
            /** @var Atom $atom */
            $atom = $this['atoms'][$atom];
            $atom->execute($controller, $action);

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->trigger('app.exec.after');
    }

    /**
     * Return current state of debug config
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
            list($atom, $helper) = explode('.', Filter::cmd($id));
            return $this['atoms'][$atom][$helper];
        }

        return parent::offsetGet($id);
    }

    /**
     * Init general paths for JBZoo
     * @throws \JBZoo\Path\Exception
     */
    protected function _initPaths()
    {
        // Assets
        $this['path']->set('assets', 'jbzoo:assets');
        //$this['path']->set('js', 'assets:js');
        //$this['path']->set('css', 'assets:css');
        //$this['path']->set('less', 'assets:less');
        //$this['path']->set('img', 'assets:img');

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

            $root = $app['path']->getRoot();

            $factory = new AssetsFactory($root, [
                'cache_path' => $app['path']->get('cache:'),
                'debug'      => $app->isDebug(),
            ]);

            $manager = new AssetsManager($factory);

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
}
