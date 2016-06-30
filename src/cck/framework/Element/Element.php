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
     */
    public function set($key, $value)
    {
        $data       = $this->_entity->elements->get($this->id, []);
        $data[$key] = $value;

        $this->_entity->elements->set($this->id, $data); // todo: check performance

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
     * @return string
     */
    public function getSearchData()
    {
        return [$this->get('value', $this->config->get('default'))];
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
            $layout = 'render.php';
        } elseif (strpos($layout, '.php') === false) {
            $layout .= '.php';
        }

        $typeName  = $this->getElementType(true);
        $groupName = $this->getElementGroup(true);

        // own layout
        $layoutPath = $this->app['path']->get("elements:{$groupName}/{$typeName}/tmpl/{$layout}");

        // parent option
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:{$groupName}/option/tmpl/{$layout}");
        }

        // parent group
        if (empty($layoutPath)) {
            $layoutPath = $this->app['path']->get("elements:core/{$groupName}/tmpl/{$layout}");
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
     * @param Data|null $params
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function hasValue(Data $params = null)
    {
        $value = $this->get('value', $this->config->get('default'));

        return !empty($value);
    }

    /**
     * @param string $name
     * @param bool   $isArray
     * @return string
     */
    public function getControlName($name = 'value', $isArray = false)
    {
        return "elements[{$this->id}][{$name}]" . ($isArray ? "[]" : "");
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
            "elements:{$group}/{$type}/assets/js/{$this->_elType}.js",
            [
                'jbzoo-jquery-factory',
                "elemenet-{$group}-{$group}-js", // parent assets
            ]
        );

        $helper->add(
            "elemenet-{$group}-{$type}-jsx",
            "elements:{$group}/{$type}/assets/jsx/{$this->_elType}.jsx",
            [
                "react",
                "elemenet-{$group}-{$group}-jsx" // parent assets
            ]
        );

        $helper->add(
            "elemenet-{$group}-{$type}-css",
            "elements:{$group}/{$type}/assets/css/{$this->_elType}.css",
            "elemenet-{$group}-{$group}-css" // parent assets
        );

        $helper->add(
            "elemenet-{$group}-{$type}-less",
            "elements:{$group}/{$type}/assets/less/{$this->_elType}.less",
            "elemenet-{$group}-{$group}-less" // parent assets
        );

        return $this;
    }

    /**
     * Validate data before save
     * @throws Exception
     */
    public function validate()
    {
        if (!$this->getEntity()) {
            $this->_throwError("Element '{$this->id}' hasn't entity object!");
        }
    }

    /**
     * @param Data $params
     * @return null|string
     */
    public function render(Data $params = null)
    {
        if ($layout = $this->getLayout($params->get('layout'))) {
            $group = $this->getElementGroup();

            $result = $this->_renderLayout($layout, [
                'params' => $params,
                'config' => $this->config,
                $group   => $this->_entity,
            ]);

            return $result;
        }

        return null;
    }

    /**
     * Is element repeatable
     * @return bool
     */
    public function isRepeatable()
    {
        return $this instanceof Repeatable;
    }

    /**
     * @param string $__layoutPath
     * @param array  $__args
     * @return null|string
     */
    protected function _renderLayout($__layoutPath, $__args = [])
    {
        $this->app->trigger(
            "element.{$this->_elGroup}.{$this->_elType}.render.before",
            [$this, &$__layoutPath, &$__args]
        );

        if (is_array($__args)) {
            foreach ($__args as $__var => $__value) {
                $$__var = $__value;
            }
        }

        $__result = null;

        $__layoutPath = realpath($__layoutPath);
        if ($__layoutPath && file_exists($__layoutPath)) {
            ob_start();
            include($__layoutPath);
            $__result = ob_get_contents();
            ob_end_clean();
        }

        $this->app->trigger(
            "element.{$this->_elGroup}.{$this->_elType}.render.after",
            [$this, &$__layoutPath, &$__args, &$__result]
        );

        return $__result;
    }

    /**
     * Alias function for elements error
     *
     * @param string $message
     * @param array  $extra
     * @throws Exception
     */
    protected function _throwError($message, $extra = [])
    {
        throw new Exception($message, 0, null, $extra);
    }
}
