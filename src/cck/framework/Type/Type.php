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

namespace JBZoo\CCK\Type;

use JBZoo\CCK\App;
use JBZoo\CCK\Element\Element;
use JBZoo\Data\Data;
use JBZoo\Utils\Filter;

/**
 * Class Type
 */
class Type
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    public $id;

    /**
     * @var Data
     */
    public $config;

    /**
     * @var array
     */
    protected $_elements = [];

    /**
     * Type constructor.
     * @param string $typeId
     */
    public function __construct($typeId)
    {
        $this->app = App::getInstance();

        $this->id = Filter::cmd($typeId);

        // Init valid configuration

        $this->config = jbdata($this->app['cfg']->find("type.{$this->id}", []));
        $this->config->set('elements', array_merge(
            $this->app['types']->getRequiredElements(),
            (array)$this->config->get('elements', [])
        ));

        $this->app->trigger("type.{$this->id}.init", [$this]);
    }


    /**
     * Init table object
     */
    public function init()
    {
        // noop
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->config->get('name', $this->id);
    }

    /**
     * @param string $elementId
     * @return Element|null
     */
    public function getElement($elementId)
    {
        $element = isset($this->_elements[$elementId]) ? $this->_elements[$elementId] : null;

        if (!$element) {
            if ($config = $this->getElementConfig($elementId)) {

                if ($element = $this->app['elements']->create($config->type, $config->group, $config)) {
                    $element->id = $elementId;

                    $this->_elements[$elementId] = $element;

                } else {
                    return null;
                }
            } else {
                return null;
            }

        }

        $element = clone($element);
        $element->setType($this);

        return $element;
    }

    /**
     * @param $elementId
     * @return Data
     */
    public function getElementConfig($elementId)
    {
        $config = $this->config->find("elements.{$elementId}");

        return $config ? jbdata($config) : null;
    }

    /**
     * @return array
     */
    public function getElementIds()
    {
        return array_keys($this->config->find("elements", []));
    }

    /**
     * @param string $mode
     * @return array
     */
    public function getElements($mode = Element::TYPE_ALL)
    {
        $elementsIds = $this->getElementIds();

        $result = [];
        foreach ($elementsIds as $elementId) {

            if ($mode === Element::TYPE_CORE && strpos($elementId, '_') !== 0) {
                continue;

            } elseif ($mode === Element::TYPE_CUSTOM && strpos($elementId, '_') === 0) {
                continue;
            }

            $result[$elementId] = $this->getElement($elementId);
        }

        return $result;
    }

    /**
     * Save type config to databse
     */
    public function save()
    {
        $this->app->trigger("type.{$this->id}.save.before", [$this]);

        $this->config->set('name', $this->getName());
        $result = $this->app['cfg']->set("type.{$this->id}", $this->config->getArrayCopy(), false);

        $this->app->trigger("type.{$this->id}.save.after", [$this]);

        return $result;
    }

    /**
     * Remove type config
     */
    public function remove()
    {
        $this->app->trigger("type.{$this->id}.remove.before", [$this]);

        $result = $this->app['cfg']->remove("type.{$this->id}");
        unset($this->app['types'][$this->id]);

        $this->app->trigger("type.{$this->id}.remove.after", [$this->id]);

        return $result;
    }
}
