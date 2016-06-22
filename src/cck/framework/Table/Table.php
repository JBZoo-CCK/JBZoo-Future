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
use JBZoo\CCK\App;
use JBZoo\SqlBuilder\Query\Delete;
use JBZoo\SqlBuilder\Query\Insert;
use JBZoo\SqlBuilder\Query\Replace;
use JBZoo\SqlBuilder\Query\Select;
use JBZoo\SqlBuilder\Query\Union;
use JBZoo\Utils\Dates;

/**
 * Class Table
 * @package JBZoo\CCK
 */
abstract class Table
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var AbstractDatabase
     */
    protected $_db;

    /**
     * @var string
     */
    protected $_table = '';

    /**
     * @var string
     */
    protected $_key = 'id';

    /**
     * @var string
     */
    protected $_dbNow = '';

    /**
     * @var string
     */
    protected $_dbNull = '0000-00-00 00:00:00';

    /**
     * Table constructor.
     *
     * @param string $name
     * @param string $key
     */
    public function __construct($name = '', $key = 'id')
    {
        $this->app = App::getInstance();
        $this->_db = $this->app['db'];

        $this->_key   = $key;
        $this->_table = $name;
        $this->_dbNow = $this->_db->quote(Dates::sql(time()), false);
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_table;
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
