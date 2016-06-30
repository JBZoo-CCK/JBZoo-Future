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

namespace JBZoo\PHPUnit;

use JBZoo\CCK\App;

/**
 * Class DataSet
 * @package JBZoo\PHPUnit
 */
class DataSet extends \PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    protected $_prefix;

    /**
     * @var array
     */
    protected $_tables = [];

    /**
     * DataSet constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_initJBZoo();

        foreach ($data as $tableName => $rows) {

            $tableName = str_replace('#__', $this->_prefix, $tableName);

            $columns = array();
            if (isset($rows[0])) {
                $columns = array_keys($rows[0]);
            }

            $metaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($tableName, $columns);
            $table    = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($metaData);

            foreach ($rows as $row) {
                $table->addRow($row);
            }

            $this->_tables[$tableName] = $table;
        }
    }

    protected function _initJBZoo()
    {
        require_once PROJECT_ROOT . '/src/cck/init.php';

        $this->app     = App::getInstance();
        $this->_prefix = $this->app['db']->getPrefix();
    }

    /**
     * @inheritdoc
     */
    protected function createIterator($reverse = false)
    {
        return new \PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->_tables, $reverse);
    }
}
