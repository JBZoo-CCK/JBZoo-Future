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

use JBZoo\CrossCMS\AbstractDatabase;
use JBZoo\SqlBuilder\Query\Delete;
use JBZoo\SqlBuilder\Query\Insert;
use JBZoo\SqlBuilder\Query\Select;

/**
 * Class ModulesAtomModelTest
 *
 * @package JBZoo\PHPUnit
 */
class ModulesAtomModelTest extends JBZooPHPUnit
{

    protected $_table = '#__jbzoo_modules';
    protected $_alias = 'tModules';

    /**
     * @var Select
     */
    protected $_select;

    /**
     * @var Insert
     */
    protected $_insert;

    /**
     * @var Delete
     */
    protected $_delete;

    /**
     * @var AbstractDatabase
     */
    protected $_db;

    private $__title  = 'test';

    public function setUp()
    {
        parent::setUp();
        $this->_db = jbzoo('db');
        $this->_select = new Select($this->_table, $this->_alias);
        $this->_insert = new Insert($this->_table, $this->_alias);
        $this->_delete = new Delete($this->_table);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->__cleanTable();
    }

    public function testGetList()
    {
        $this->__cleanTable();
        $table = $this->app['models']['modules'];
        isClass('JBZoo\CCK\Atom\Modules\Table\Modules', $table);

        $modules = $table->getList();
        isTrue(is_array($modules));
        isSame([], $modules);

        $sql = $this->_insert
            ->multi([
                [
                    'title'  => $this->__title,
                    'params' => 'my custom params',
                ],
                [
                    'title'  => $this->__title,
                    'params' => 'new params',
                ]
            ]);

        $this->_db->query($sql);
        $modules = $table->getList();
        isSame(2, count($modules));
    }

    public function testGetModule()
    {
        $this->__truncate();
        $this->__writeTestRecord();

        $id    = 1;
        $table = $this->app['models']['modules'];

        $actual = $table->get($id);
        $expected = [
            'id' => '1',
            'title' => 'test',
            'params' => 'my custom params',
        ];

        isSame($expected, $actual);
    }

    public function testDeleteModule()
    {
        $this->__truncate();
        $this->__writeTestRecord();

        $sql = $this->_select->where(['id', '= 1']);
        $actual = $this->_db->fetchRow($sql);
        $expected = [
            'id' => '1',
            'title' => 'test',
            'params' => 'my custom params',
        ];

        isSame($expected, $actual);

        $table = $this->app['models']['modules'];
        isTrue($table->delete(1));

        $sql = $this->_select->where(['id', '= 1']);
        $actual = $this->_db->fetchRow($sql);
        isNull($actual);
    }

    public function testAddNewModule()
    {
        $table = $this->app['models']['modules'];
        $title = 'test';
        isTrue($table->add($title, 'my params'));
        
        $actual = $this->__getModule();
        isSame($title, $actual['title']);
    }

    private function __getModule()
    {
        $sql = $this->_select->where("title = '{$this->__title}'");
        return $this->_db->fetchRow($sql);
    }

    private function __cleanTable()
    {
        $sql = $this->_delete->where("title = '{$this->__title}'");
        return $this->_db->query($sql);
    }

    private function __truncate()
    {
        $this->_db->query('TRUNCATE TABLE ' . $this->_table);
    }

    private function __writeTestRecord()
    {
        $sql = $this->_insert
            ->row([
                'title'  => $this->__title,
                'params' => 'my custom params',
            ]);

        $this->_db->query($sql);
    }
}
