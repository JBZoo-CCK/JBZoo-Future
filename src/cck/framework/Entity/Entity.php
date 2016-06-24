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

use JBZoo\CCK\App;
use JBZoo\CCK\Table\Table;

/**
 * Class Entity
 * @package JBZoo\CCK
 */
abstract class Entity
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    protected $_tableName;

    /**
     * Entity constructor.
     * @param array $rowData
     */
    public function __construct($rowData = [])
    {
        $this->app = App::getInstance();

        if ($rowData) {
            // TODO: check performance
            foreach ($rowData as $propName => $propValue) {
                if ($propName != 'app' && property_exists($this, $propName)) {
                    $this->$propName = $propValue;
                }
            }
        }
    }

    /**
     * Init entity state
     */
    public function init()
    {
        // noop
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {

            if ($key == 'app' || strpos($key, '_') === 0) { // No global app and private props
                continue;
            }

            $result[$key] = is_object($value) ? (array)$value : $value;
        }

        return $result;
    }

    /**
     * Save entity to databse via table model
     */
    public function save()
    {
        if ($this->_tableName) {

            /** @var Table $table */
            $table = $this->app['models'][$this->_tableName];
            $id = $table->saveEntity($this);

            $this->{$table->getKey()} = $id;

            return $id;
        }

        return false;
    }

    /**
     * Remove entity from database
     */
    public function remove()
    {
        if ($this->_tableName) {

            /** @var Table $table */
            $table = $this->app['models'][$this->_tableName];
            return $table->removeEntity($this);
        }

        return false;
    }
}
