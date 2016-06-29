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

namespace JBZoo\CCK\Entity;

use JBZoo\CCK\Element\Element;
use JBZoo\CCK\Type\Type;
use JBZoo\Data\JSON;

/**
 * Class Item
 */
class Item extends EntityElements
{
    /**
     * The id of the item
     * @var int
     */
    public $id = 0;

    /**
     * The name of the item
     * @var string
     */
    public $name = '';

    /**
     * The type identifier of the Item
     * @var string
     */
    public $type = '';

    /**
     * The alias of the item
     * @var string
     */
    public $alias = '';

    /**
     * The creation date of the item in mysql DATETIME format
     * @var string
     */
    public $created = '0000-00-00 00:00:00';

    /**
     * The last modified date of the item in mysql DATETIME format
     * @var string
     */
    public $modified = '0000-00-00 00:00:00';

    /**
     * The date from which the item should be published
     * @var string
     */
    public $publish_up = '0000-00-00 00:00:00';

    /**
     * The date up until the item should be published
     * @var string
     */
    public $publish_down = '0000-00-00 00:00:00';

    /**
     * The item priority. An higher priority means that an item should be shown before
     * @var int
     */
    public $priority = 0;

    /**
     * Item published state
     * @var int
     */
    public $state = 0;

    /**
     * The access level required to see this item
     * @var int
     */
    public $access = 0;

    /**
     * The id of the user that created the item
     * @var int
     */
    public $created_by = 0;

    /**
     * The item parameters
     * @var JSON
     */
    public $params;

    /**
     * The elements of the item encoded in json format
     * @var JSON
     */
    public $elements;

    /**
     * The elements of the item encoded in json format
     * @var array[Element]
     */
    protected $_elements = [];

    /**
     * @var string
     */
    protected $_tableName = 'item';

    /**
     * @var Type
     */
    protected $_type;

    /**
     * Item constructor.
     * @param array $rowData
     */
    public function __construct(array $rowData = [])
    {
        parent::__construct($rowData);

        $this->elements = jbdata($this->elements);
        $this->params   = jbdata($this->params);
    }

    /**
     * Get the item Type
     *
     * @return Type The item Type
     *
     * @since 2.0
     */
    public function getType()
    {
        if (!$this->_type && $this->type) {
            $this->_type = $this->app['types'][$this->type];
        }

        return $this->_type;
    }

    /**
     * @param $elementId
     * @return Element
     */
    public function getElement($elementId)
    {
        if (isset($this->_elements[$elementId])) {
            return $this->_elements[$elementId];
        }

        if ($element = $this->getType()->getElement($elementId)) {
            $element->setEntity($this);
            $this->_elements[$elementId] = $element;
            return $element;
        }

        return null;
    }

    /**
     * @return array[Element]
     */
    public function getCoreElements()
    {
        if ($type = $this->getType()) {
            $coreElements = $type->getElements('core');

            /** @var Element $element */
            foreach ($coreElements as $element) {
                $element->setEntity($this);
            }

            return $coreElements;
        }

        return [];
    }

    /**
     * @return array[Element]
     */
    public function getElements()
    {
        if ($type = $this->getType()) {

            $elementIds = $type->getElementIds();

            /** @var Element $element */
            foreach ($elementIds as $elementId) {

                if (!isset($this->_elements[$elementId])) {
                    $element = $type->getElement($elementId);
                    $element->setEntity($this);
                    $this->_elements[$element->id] = $element;
                }
            }
        }

        return $this->_elements;
    }

    /**
     * @param $type
     * @return array
     */
    public function getElementsByType($type)
    {
        $type = strtolower($type);

        return array_filter($this->getElements(), function ($element) use ($type) {
            /** @var Element $element */
            return $element->getElementType() === $type;
        });
    }
}
