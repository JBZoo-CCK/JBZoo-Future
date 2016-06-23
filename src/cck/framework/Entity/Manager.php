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
    protected $_entities = [];

    /**
     * @param string $atomId
     * @param string $tableClass
     * @throws Exception
     */
    public function addEntity($atomId, $tableClass)
    {
        $tableClass = strtolower($tableClass);

        if (!isset($this->_entities[$tableClass])) {

            $className = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Entity\\' . ucfirst($tableClass);
            if (class_exists($className)) {

                $this->_entities[$tableClass] = $className;

                $this[$tableClass] = function () use ($className) {
                    return $className;
                };

            } else {
                throw new Exception("Entity class \"{$className}\" in not exists!");
            }

        } else {
            throw new Exception("Entity \"{$atomId}.{$tableClass}\" already defined!");
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

        if (!isset($this->_entities[$id])) {
            throw new Exception("Entity \"{$id}\" is not defined!");
        }

        return parent::offsetGet($id);
    }
}
