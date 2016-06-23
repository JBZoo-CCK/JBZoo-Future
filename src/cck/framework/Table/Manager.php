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
        $tableClass = strtolower($tableClass);

        if (!isset($this->_tables[$tableClass])) {

            $classEntity = $entity ?: $tableClass;

            $classTable  = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Table\\' . ucfirst($tableClass);
            $classEntity = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Entity\\' . ucfirst($classEntity);

            if (class_exists($classTable)) {

                $this->_tables[$tableClass] = $classTable;

                $this[$tableClass] = function () use ($classTable, $classEntity) {
                    $tableObject = new $classTable();

                    if (class_exists($classEntity)) {
                        $tableObject->entity = $classEntity;
                    }

                    return $tableObject;
                };

            } else {
                throw new Exception("Table class \"{$classTable}\" in not exists!");
            }

        } else {
            throw new Exception("Table \"{$atomId}.{$tableClass}\" already defined!");
        }
    }

    /**
     * @param string $id
     * @return \JBZoo\CCK\Table\Table
     * @throws Exception
     */
    public function offsetGet($id)
    {
        $id = strtolower($id);

        if (!isset($this->_tables[$id])) {
            throw new Exception("Table \"{$id}\" is not defined!");
        }

        return parent::offsetGet($id);
    }
}
