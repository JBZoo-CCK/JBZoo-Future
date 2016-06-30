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

use JBZoo\Data\Data;

/**
 * Class Repeatable
 * @package JBZoo\CCK\Element
 */
abstract class Repeatable extends Element implements \Countable, \SeekableIterator
{
    /**
     * Current pointer
     * @var int
     */
    private $_position = 0;

    /**
     * @inheritdoc
     */
    public function get($key, $default = null, $filter = null)
    {
        return parent::get("{$this->_position}.{$key}", $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function set($key, $value)
    {
        if ($this->_entity) {
            $data = $this->_entity->elements->find("{$this->id}.{$this->_position}", []);
            $data += [$key => $value];

            parent::set($this->_position, $data);
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function bindData($data = [])
    {
        $this->app->trigger("element.{$this->_elGroup}.{$this->_elType}.bindData", [$this]);

        if ($this->_entity) {
            $this->_entity->elements->set($this->id, array_merge((array)$data));
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getSearchData()
    {
        $result = [];
        foreach ($this as $thisValue) {
            $result[] = $this->_getSearchData();
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function _getSearchData()
    {
        return $this->get('value', $this->config->get('default'));
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function hasValue(Data $params = null)
    {
        if (!$this->_entity) {
            return false;
        }

        foreach ($this as $self) {
            if ($this->_hasValue($params)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Data|null $params
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _hasValue(Data $params = null)
    {
        $value = $this->get('value', $this->config->get('default'));

        return !empty($value);
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function render(Data $params = null)
    {
        $params = jbdata($params);
        $result = [];

        foreach ($this as $self) {
            $result[] = $this->_render($params);
        }

        return $this->app['elements']->applySeparators($params->get('separated_by'), $result);
    }

    /**
     * @param Data|null $params
     * @return string
     */
    protected function _render(Data $params = null)
    {
        $params  = jbdata($params);
        $default = $this->config->get('default');
        $value   = $this->get('value', $default);

        // render layout
        if ($layout = $this->getLayout($params->get('layout'))) {
            return $this->_renderLayout($layout, [
                'value'  => $value,
                'params' => $params
            ]);
        }

        return $value;
    }

    /**
     * @param string $name
     * @param bool   $isArray
     * @return string
     */
    public function getControlName($name = 'value', $isArray = false)
    {
        return "elements[{$this->id}][{$this->key()}][{$name}]" . ($isArray ? "[]" : "");
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return parent::get($this->_position);
    }

    /**
     * Get next element
     */
    public function next()
    {
        ++$this->_position;
    }

    /**
     * Get current position
     * @return int
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        if ($this->_position == 0
            && $this->_entity
            && !isset($this->_entity->elements[$this->id])
            && !isset($this->_entity->elements[$this->id][0])
        ) {
            parent::set(0, []);
        }

        if ($this->_entity) {
            return parent::get($this->_position) !== null;
        }

        return false;
    }

    /**
     * Reset position
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * @return int
     */
    public function count()
    {
        if (isset($this->_entity, $this->_entity->elements[$this->id])) {
            return count($this->_entity->elements[$this->id]);
        }

        return 0;
    }

    /**
     * @param $newPosition
     * @return null
     */
    public function seek($newPosition)
    {
        $this->_position = $newPosition;
        return $this->valid();
    }
}
