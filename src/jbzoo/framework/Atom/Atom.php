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

use JBZoo\CCK\App;
use JBZoo\CCK\Container;
use JBZoo\Data\Data;
use JBZoo\Utils\Cli;
use JBZoo\Utils\Filter;
use JBZoo\Utils\FS;

/**
 * Class Atom
 * @package JBZoo\CCK
 */
abstract class Atom extends Container
{
    /**
     * @var string
     */
    protected $_id;

    /**
     * @var string
     */
    protected $_path;

    /**
     * @var string
     */
    protected $_ns;

    /**
     * @var Data
     */
    protected $_config;

    /**
     * @var Data
     */
    protected $_meta;

    /**
     * @var Data
     */
    protected $_extra;

    /**
     * @var callable
     */
    protected $_init;

    /**
     * Atom constructor.
     * @param string $atomId
     * @param Data   $info
     */
    public function __construct($atomId, Data $info)
    {
        parent::__construct();

        $this->_id = Filter::_($atomId, 'cmd,low');

        $this->_config = jbdata($info->get('config', []));
        $this->_meta   = jbdata($info->get('meta', []));
        $this->_extra  = jbdata($info->get('extra', []));
        $this->_init   = $info->get('init');

        $this->_ns   = __NAMESPACE__ . '\\' . Filter::className($this->_id);
        $this->_path = $info->get('dir');

        foreach ($info->get('events', []) as $eventName => $handler) {
            $this->app->on($eventName, $handler);
        }

        if (FS::isDir($this->_path . '/assets')) {
            $this->app['path']->set('assets', $this->_path . '/assets');
        }
    }

    /**
     * Get Atom config
     * @return Data
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Get Atom metadata
     * @return Data
     */
    public function getMeta()
    {
        return $this->_meta;
    }

    /**
     * @param App $app
     */
    public function init(App $app)
    {
        if (is_callable($this->_init)) {
            call_user_func_array($this->_init, [$app, $this]);
        }
    }

    /**
     * @param string $prefix
     * @param string $className
     * @return string
     */
    public function getClass($prefix, $className)
    {
        return $this->_ns . '\\' . Filter::className($prefix) . '\\' . Filter::className($className);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Execute action in controller
     *
     * @param string $controller
     * @param string $action
     * @return null|mixed
     */
    public function execute($controller = 'index', $action = 'index')
    {
        $ctrlClass = $this->getClass('controller', $controller);

        if (class_exists($ctrlClass)) {

            /** @var Controller $ctrlObject */
            $ctrlObject = new $ctrlClass();
            $ctrlObject->setAtom($this);

            if (method_exists($ctrlObject, $action)) {

                ob_start();

                $this->app->trigger("atom.ctrl.before");
                $this->app->trigger("atom.ctrl.{$controller}.before");
                $this->app->trigger("atom.ctrl.{$controller}.{$action}.before");

                $result = call_user_func_array([$ctrlObject, $action], [$this]);

                $this->app->trigger("atom.ctrl.{$controller}.{$action}.after");
                $this->app->trigger("atom.ctrl.{$controller}.after");
                $this->app->trigger("atom.ctrl.after");

                // TODO: Move it to helper
                if (!(Cli::check() || $this->app['request']->isAjax())) {
                    $this->app->trigger('jbzoo.assets');
                }

                $content = ob_get_contents();
                ob_end_clean();

                return $content ? $content : $result;
            }

            $this->app->error("Action not found:  {$this->_id}.{$controller}.{$action}");

        } else {
            $this->app->error("Controller not found: {$this->_id}.{$controller}");
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $helperClass = $this->getClass('helper', $offset);

        if (!isset($this[$offset]) && class_exists($helperClass)) {

            $this[$offset] = function () use ($helperClass, $offset) {
                return new $helperClass($this, $offset);
            };
        }

        return parent::offsetGet($offset);
    }
}
