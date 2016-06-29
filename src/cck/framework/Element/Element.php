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
use JBZoo\CCK\Type\Type;
use JBZoo\Data\Data;
use JBZoo\Data\PHPArray;

/**
 * Class Element
 * @package JBZoo\CCK\Element
 */
abstract class Element
{
    const TYPE_ALL    = 'all';
    const TYPE_CORE   = 'core';
    const TYPE_CUSTOM = 'custom';

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
     * @var Type
     */
    public $type;

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
    protected $_elGroup;

    /**
     * @var string
     */
    protected $_elType;

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

        $this->_elGroup = strtolower($group);
        $this->_elType  = strtolower($type);
    }

    /**
     * Init entity state
     */
    public function init()
    {
        $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.init", [$this]);
    }


    /**
     * @param bool $ucfirst
     * @return string
     */
    public function getElementType($ucfirst = false)
    {
        return $ucfirst ? ucfirst($this->_elType) : $this->_elType;
    }

    /**
     * @param bool $ucfirst
     * @return string
     */
    public function getElementGroup($ucfirst = false)
    {
        return $ucfirst ? ucfirst($this->_elGroup) : $this->_elGroup;
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
     *
     * @todo check performance
     */
    public function set($key, $value)
    {
        $elementData = $this->_entity->elements->get($this->id, []);

        $elementData[$key] = $value;

        $this->_entity->elements->set($this->id, $elementData);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function bindData($data = [])
    {
        $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.bindData", [$this]);

        if (isset($this->_entity)) {
            $this->_entity->elements->set($this->id, $data);
        }

        return $this;
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
     * @param Type $type
     */
    public function setType(Type $type)
    {
        $this->type = $type;
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
            $layout = $this->_elType . '.php';
        } elseif (strpos($layout, '.php') === false) {
            $layout .= '.php';
        }

        // own layout
        $layoutPath = $this->app['path']->get("elements:{$this->_elGroup}/{$this->_elType}/tmpl/{$layout}");

        // parent option
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:{$this->_elGroup}/option/tmpl/{$layout}");
        }

        // parent group
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:core/{$this->_elGroup}/tmpl/{$layout}");
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
        $groupDir = ucfirst($this->_elGroup);
        $typeDir  = ucfirst($this->_elType);

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

        $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.loadAssets", [$this]);

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
        $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.render.before", [$this, $params]);

        if ($layout = $this->getLayout($params->get('layout'))) {
            $group = $this->getElementGroup();

            $result = $this->_renderLayout($layout, [
                'params' => $params,
                'config' => $this->config,
                $group   => $this->_entity,
            ]);

            $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.render.after", [$this, $params, &$result]);

            return $result;
        }

        return null;
    }

    /**
     * @param string $__layoutPath
     * @param array  $__args
     * @return null|string
     */
    protected function _renderLayout($__layoutPath, $__args = [])
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
