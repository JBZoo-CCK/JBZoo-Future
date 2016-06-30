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

namespace JBZoo\CCK\Table;

use JBZoo\CCK\Container;
use JBZoo\CCK\Exception\Exception;

/**
 * Class Manager
 * @package JBZoo\CCK
 */
class Manager extends Container
{
    /**
     * @var array
     */
    protected $_tables = [];

    /**
     * @param string $atomId
     * @param string $tableClass
     * @param string $entity
     * @throws Exception
     */
    public function addModel($atomId, $tableClass, $entity = null)
    {
        $id     = strtolower($tableClass);
        $entity = $entity ? strtolower($entity) : $id;

        if (!isset($this->_tables[$id])) {
            $classTable  = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Table\\' . ucfirst($id);
            $classEntity = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Entity\\' . ucfirst($entity);

            $this->_register($id, $classTable, $classEntity);

        } else {
            throw new Exception("Table \"{$atomId}.{$tableClass}\" already defined!");
        }
    }

    /**
     * @param $id
     * @param $classTable
     * @param $classEntity
     * @throws Exception
     */
    protected function _register($id, $classTable, $classEntity)
    {
        if (class_exists($classTable)) {
            $this->_tables[$id] = $classTable;

            $this[$id] = function () use ($classTable, $classEntity) {

                /** @var Table $tableObject */
                $tableObject = new $classTable();

                if (class_exists($classEntity)) {
                    $tableObject->entity = $classEntity;
                }

                $tableObject->init();

                return $tableObject;
            };
        } else {
            throw new Exception("Table class \"{$classTable}\" in not exists!");
        }
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function offsetGet($id)
    {
        $id = strtolower($id);

        if (!isset($this->_tables[$id])) {
            $classTable  = '\JBZoo\CCK\Table\\' . ucfirst($id);
            $classEntity = '\JBZoo\CCK\Entity\\' . ucfirst($id);

            $this->_register($id, $classTable, $classEntity);
        }

        return parent::offsetGet($id);
    }

    /**
     * Remove all types froma memory cache
     */
    public function cleanObjects()
    {
        $keys = $this->keys();

        foreach ($keys as $key) {
            $this[$key]->cleanObjects();
        }
    }
}
