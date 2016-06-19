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

use JBZoo\CrossCMS\AbstractDatabase;
use JBZoo\SqlBuilder\Query\Delete;
use JBZoo\SqlBuilder\Query\Insert;
use JBZoo\SqlBuilder\Query\Replace;
use JBZoo\SqlBuilder\Query\Select;
use JBZoo\SqlBuilder\Query\Union;

/**
 * Class Table
 * @package JBZoo\CCK
 */
abstract class Table
{
    /**
     * @var AbstractDatabase
     */
    protected $_db;

    /**
     * Core constructor
     */
    public function __construct()
    {
        $this->_db = jbzoo('db');
    }

    /**
     * @param string $tableName
     * @param null   $alias
     * @return Select
     */
    protected function _select($tableName, $alias = null)
    {
        return new Select($tableName, $alias);
    }

    /**
     * @param string $tableName
     * @return Replace
     */
    protected function _replace($tableName)
    {
        return new Replace($tableName);
    }

    /**
     * @param string $tableName
     * @return Insert
     */
    protected function _insert($tableName)
    {
        return new Insert($tableName);
    }

    /**
     * @param string $tableName
     * @param null   $alias
     * @return Delete
     */
    protected function _delete($tableName, $alias = null)
    {
        return new Delete($tableName, $alias);
    }

    /**
     * @return Union
     */
    protected function _union()
    {
        return new Union();
    }
}
