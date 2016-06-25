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
     * @var string
     */
    protected $_tableName = 'item';

    /**
     * Init item after create
     */
    public function init()
    {
        parent::init();

        $this->elements = jbdata($this->elements);
        $this->params   = jbdata($this->params);
    }

    /**
     * Get an element object out of this item
     * @param  string $elementId
     * @return Element
     */
    public function getElement($identifier)
    {
        if (isset($this->_elements[$identifier])) {
            return $this->_elements[$identifier];
        }

        if ($element = $this->getType()->getElement($identifier)) {
            $element->setItem($this);
            $this->_elements[$identifier] = $element;
            return $element;
        }

        return null;
    }

    /**
     * Get a list of the Core Elements
     *
     * @return array The list of core elements
     *
     * @since 2.0
     */
    public function getCoreElements()
    {

        // get types core elements
        if ($type = $this->getType()) {
            $core_elements = $type->getCoreElements();
            foreach ($core_elements as $element) {
                $element->setItem($this);
            }
            return $core_elements;
        }

        return array();
    }

    /**
     * Get the list of elements
     *
     * @return array The element list
     *
     * @since 2.0
     */
    public function getElements()
    {

        // get types elements
        if ($type = $this->getType()) {
            foreach ($type->getElements() as $element) {
                if (!isset($this->_elements[$element->identifier])) {
                    $element->setItem($this);
                    $this->_elements[$element->identifier] = $element;
                }
            }
            $this->_elements = $this->_elements ? $this->_elements : array();
        }

        return $this->_elements;
    }

    /**
     * Get a list of elements filtered by type
     *
     * @return array The element list
     *
     * @since 3.0.6
     */
    public function getElementsByType($type)
    {
        return array_filter($this->getElements(), function ($element) use ($type) {
            return $element->getElementType() == "' . $type . '";
        });
    }

    /**
     * Get a list of elements that support submissions
     *
     * @return array The submittable elements
     *
     * @since 2.0
     */
    public function getSubmittableElements()
    {
        return array_filter($this->getElements(), function ($element) {
            //return $element instanceof iSubmittable;
        });
    }
}
