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

namespace JBZoo\CCK\Element;

use JBZoo\CCK\App;
use JBZoo\CCK\Entity\EntityElements;
use JBZoo\Data\Data;
use JBZoo\Data\PHPArray;

/**
 * Class Entity
 * @package JBZoo\CCK
 */
abstract class Element
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    public $id = '';

    /**
     * @var Data
     */
    public $config;

    /**
     * @var Data
     */
    public $data;

    /**
     * @var Data
     */
    protected $_meta;

    /**
     * @var EntityElements
     */
    protected $_entity;

    /**
     * @var string
     */
    protected $_group;

    /**
     * @var string
     */
    protected $_type;

    /**
     * Element constructor.
     * @param string $type
     * @param string $group
     */
    public function __construct($type, $group)
    {
        $this->app = App::getInstance();

        $this->config = jbdata();
        $this->data   = jbdata();

        $this->_group = strtolower($group);
        $this->_type  = strtolower($type);
    }

    /**
     * @param bool $ucfirst
     * @return string
     */
    public function getElementType($ucfirst = false)
    {
        return $ucfirst ? ucfirst($this->_type) : $this->_type;
    }

    /**
     * @param bool $ucfirst
     * @return string
     */
    public function getElementGroup($ucfirst = false)
    {
        return $ucfirst ? ucfirst($this->_group) : $this->_group;
    }

    /**
     * @param string $key
     * @param null   $default
     * @param null   $filter
     * @return mixed
     */
    public function get($key, $default = null, $filter = null)
    {
        return $this->_entity->elements->find($this->id . '.' . $key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->_entity->elements[$this->id][$key] = $value;
        return $this;
    }

    /**
     * @param array $data
     */
    public function bindData($data = array())
    {
        if (isset($this->_entity)) {
            $this->_entity->elements->set($this->id, $data);
        }
    }

    /**
     * @return array
     */
    public function data()
    {
        if (isset($this->_entity)) {
            return $this->_entity->elements->get($this->id);
        }

        return [];
    }

    /**
     * Get element layout path and use override if exists
     * @param null|string $layout
     * @return string
     */
    public function getLayout($layout = null)
    {
        // set default
        if (empty($layout)) {
            $layout = $this->_type . '.php';
        } elseif (strpos($layout, '.php') === false) {
            $layout .= '.php';
        }

        // own layout
        $layoutPath = $this->app['path']->get("elements:{$this->_group}/{$this->_type}/tmpl/{$layout}");

        // parent option
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:{$this->_group}/option/tmpl/{$layout}");
        }

        // parent group
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:core/{$this->_group}/tmpl/{$layout}");
        }

        // global
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:core/element/tmpl/{$layout}");
        }

        return $layoutPath;
    }

    /**
     * Set new config data
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = jbdata($config);
    }

    /**
     * Set Entity object (context)
     * @param EntityElements $entity
     */
    public function setEntity(EntityElements $entity)
    {
        $this->_entity = $entity;
    }

    /**
     * Get Entity object (context)
     * @return EntityElements
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $groupDir = ucfirst($this->_group);
        $typeDir  = ucfirst($this->_type);

        return $this->app['path']->get("elements:{$groupDir}/{$typeDir}");
    }

    /**
     * @return PHPArray
     */
    public function loadMeta()
    {
        if (!$this->_meta) {
            $this->_meta = new PHPArray($this->getPath() . '/element.manifest.php');
        }

        return $this->_meta;
    }

    /**
     * @param      $key
     * @param null $default
     * @param null $filter
     * @return mixed
     */
    public function getMetaData($key, $default = null, $filter = null)
    {
        return $this->loadMeta()->find("meta.{$key}", $default, $filter);
    }

    /**
     * @return string
     */
    public function getName()
    {
        $retult = $this->config->get('name');

        if (!$retult) {
            $retult = $this->getMetaData('name');
        }

        return $retult;
    }

    /**
     * @return mixed
     */
    public function isCore()
    {
        return $this->getMetaData('core', false, 'bool');
    }

    /**
     * Set related type object
     * @return bool
     */
    public function hasValue()
    {
        $value = $this->get('value', $this->config->get('default'));
        return !empty($value);
    }

    /**
     * Load elements assets
     * @return $this
     */
    public function loadAssets()
    {
        $group = $this->getElementGroup(true);
        $type  = $this->getElementType(true);

        $helper = $this->app['assets'];

        $helper->add(
            "elemenet-{$group}-{$type}-js",
            "elements:{$group}/{$type}/assets/js/{$type}.js",
            "elemenet-{$group}-{$group}-js" // parent assets
        );

        $helper->add(
            "elemenet-{$group}-{$type}-css",
            "elements:{$group}/{$type}/assets/css/{$type}.css",
            "elemenet-{$group}-{$group}-css" // parent assets
        );

        $helper->add(
            "elemenet-{$group}-{$type}-less",
            "elements:{$group}/{$type}/assets/less/{$type}.less",
            "elemenet-{$group}-{$group}-less" // parent assets
        );

        return $this;
    }

    /**
     * @param Data $params
     * @return null|string
     */
    public function render(Data $params)
    {
        if ($layout = $this->getLayout($params->get('layout'))) {
            $group = $this->getElementGroup();

            return $this->_renderLayout($layout, array(
                'params' => $params,
                'config' => $this->config,
                $group   => $this->_entity,
            ));
        }

        return null;
    }

    /**
     * @param string $__layoutPath
     * @param array  $__args
     * @return null|string
     */
    protected function _renderLayout($__layoutPath, $__args = array())
    {
        if (is_array($__args)) {
            foreach ($__args as $__var => $__value) {
                $$__var = $__value;
            }
        }

        $__html = null;

        if (file_exists($__layoutPath)) {
            ob_start();
            include($__layoutPath);
            $__html = ob_get_contents();
            ob_end_clean();
        }

        return $__html;
    }
}
