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
use JBZoo\CCK\Element\Exception as ElementException;
use JBZoo\CCK\Exception;
use JBZoo\CCK\Type\Type;
use JBZoo\Data\JSON;

/**
 * Class Item
 */
class Item extends EntityElements
{
    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_ARCHIVE  = 2;

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $alias = '';

    /**
     * @var string
     */
    public $type = '';

    /**
     * @var int
     */
    public $status = self::STATUS_UNACTIVE;

    /**
     * @var int
     */
    public $created_by = 0;

    /**
     * @var string
     */
    public $created = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    public $modified = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    public $publish_up = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    public $publish_down = '0000-00-00 00:00:00';

    /**
     * @var JSON
     */
    public $params;

    /**
     * @var JSON
     */
    public $elements;

    /**
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
     * @return Type
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
     * @param string $mode
     * @return array
     */
    public function getElements($mode = Element::TYPE_ALL)
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

        if ($mode !== Element::TYPE_ALL) {
            return array_filter($this->_elements, function ($element) use ($mode) {
                /** @var Element $element */

                if ($mode === Element::TYPE_CORE && !$element->isCore()) {
                    return false;

                } elseif ($mode === Element::TYPE_CUSTOM && $element->isCore()) {
                    return false;
                }

                return true;
            });
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

    /**
     * @return array
     */
    public function validate()
    {
        $elements = $this->getElements();

        $errors = [];

        /** @var Element $element */
        foreach ($elements as $element) {

            try {
                $element->validate();
            } catch (ElementException $e) {
                $errors[$element->id] = $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @return bool|int
     * @throws Exception
     */
    public function save()
    {
        $errors = $this->validate();

        if (empty($errors)) {
            return parent::save();
        }

        $this->_throwError("Item {$this->id} is not valid!", $errors);
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return (int)$this->id === 0;
    }
}
