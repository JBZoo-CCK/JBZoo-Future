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
use JBZoo\Utils\Str;

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
     * @var string
     */
    protected $_entityName;

    /**
     * Entity constructor.
     * @param array $rowData
     */
    public function __construct(array $rowData = [])
    {
        $this->app = App::getInstance();

        $this->_entityName = Str::getClassName($this, true);

        $this->bindData($rowData);

        $this->app->trigger("entity.{$this->_entityName}.init", [$this]);
    }

    /**
     * @param $rowData
     */
    public function bindData($rowData)
    {
        if ($rowData) {

            $this->app->trigger("entity.{$this->getEntityName()}.bind", [$this, $rowData]);

            foreach ($rowData as $propName => $propValue) {
                if ($propName != 'app' && property_exists($this, $propName)) {
                    $this->$propName = $propValue; // TODO: check performance
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->_entityName;
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

            $this->app->trigger("entity.{$this->_entityName}.save.before", [$this]);

            /** @var Table $table */
            $table = $this->app['models'][$this->_tableName];
            $id    = $table->saveEntity($this);

            $this->{$table->getKey()} = $id;

            $this->app->trigger("entity.{$this->_entityName}.save.after", [$this]);

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

            $this->app->trigger("entity.{$this->_entityName}.remove.before", [$this]);

            /** @var Table $table */
            $table  = $this->app['models'][$this->_tableName];
            $result = $table->removeEntity($this);

            $this->app->trigger("entity.{$this->_entityName}.remove.after", [$this, $result]);

            return $result;
        }

        return false;
    }

    /**
     * Alias function for elements error
     * @param string $message
     * @param null   $extra
     * @throws Exception
     */
    protected function _throwError($message, $extra = null)
    {
        throw new Exception($message, 0, null, $extra);
    }
}
