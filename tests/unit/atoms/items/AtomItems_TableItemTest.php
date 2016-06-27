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
use JBZoo\CCK\Table\Item as ItemTable;
use JBZoo\CCK\Entity\Item as ItemEntity;

/**
 * Class AtomItems_TableItemTest
 */
class AtomItems_TableItemTest extends JBZooPHPUnitDatabase
{
    protected $_fixtureFile = 'AtomItems_TableItemTest.php';

    protected function setUp()
    {
        parent::setUp();
        //$this->_table()->cleanObjects();
    }

    /**
     * @return ItemTable
     */
    protected function _table()
    {
        return $this->app['models']['item'];
    }

    public function testClassName()
    {
        isClass('\JBZoo\CCK\Table\Item', $this->_table());
        isSame('#__jbzoo_items', JBZOO_TABLE_ITEMS);
    }

    public function testRemove()
    {
        $this->_table()->remove(1);

        is(1, count($this->_table()->getList()));
    }

    public function testGet()
    {
        $item1 = $this->_table()->get(1);
        $item2 = $this->_table()->get(1);
        isSame($item1, $item2);
    }

    public function testInit()
    {
        /** @var ItemEntity $item */
        $item = $this->_table()->get(3);

        isClass('JBZoo\Data\Data', $item->elements);
        isClass('JBZoo\Data\Data', $item->params);
        isSame('Item 3', $item->name);
        isSame('item-3', $item->alias);
        isSame('0', $item->state);
        isSame('3', $item->id);
    }

    public function testUnset()
    {
        $item1 = $this->_table()->get(1);
        $this->_table()->unsetObject(1);
        $item2 = $this->_table()->get(1);

        isNotSame($item1, $item2);
    }

    public function testHasObject()
    {
        $this->_table()->cleanObjects();
        isFalse($this->_table()->hasObject(1));

        $this->_table()->get(1);
        isTrue($this->_table()->hasObject(1));

        $this->_table()->unsetObject(1);
        isFalse($this->_table()->hasObject(1));
    }

    public function testGetList()
    {
        is(2, count($this->_table()->getList()));
    }

    public function testToArray()
    {
        /** @var ItemEntity $item */
        $item = $this->_table()->get(2);

        isSame([
            "id"           => "2",
            "name"         => "Item 2",
            "type"         => "",
            "alias"        => "item-2",
            "created"      => "0000-00-00 00:00:00",
            "modified"     => "0000-00-00 00:00:00",
            "publish_up"   => "0000-00-00 00:00:00",
            "publish_down" => "0000-00-00 00:00:00",
            "priority"     => 0,
            "state"        => "1",
            "access"       => 0,
            "created_by"   => "0",
            "params"       => [],
            "elements"     => [],
        ], $item->toArray());
    }

    public function testSaveNewItem()
    {
        /** @var ItemEntity $item */
        $item        = new ItemEntity();
        $item->name  = 'Item new';
        $item->alias = 'item-new';
        $item->save();

        is(4, $item->id);
        isSame('Item new', $item->name);
        isSame('item-new', $item->alias);

        /** @var ItemEntity $itemNew */
        $itemNew = $this->_table()->get(4);
        is(4, $itemNew->id);
        isSame('Item new', $itemNew->name);
        isSame('item-new', $itemNew->alias);
    }

    public function testUpdateItem()
    {
        /** @var ItemEntity $item */
        $item        = new ItemEntity();
        $item->name  = 'Item new';
        $item->alias = 'item-new';
        is(4, $item->save());

        is(4, $item->id);
        isSame('Item new', $item->name);
        isSame('item-new', $item->alias);

        $item->name = 'Another name';
        is(4, $item->save());

        $this->_table()->cleanObjects();
        /** @var ItemEntity $itemNew */
        $itemNew = $this->_table()->get(4);
        is(4, $itemNew->id);
        isSame('Another name', $itemNew->name);
        isSame('item-new', $itemNew->alias);
    }

    public function testGetUndefined()
    {
        $undefinedItem = $this->_table()->get(100500);
        isNull($undefinedItem);

        isFalse($this->_table()->hasObject(100500));
    }

    public function testRemoveItem()
    {
        $item = $this->_table()->get(1);
        isTrue($item);
        isTrue($item->remove());

        $item = $this->_table()->get(1);
        isFalse($item);
        isFalse($this->_table()->hasObject(1));
    }

    public function testElementData()
    {
        /** @var ItemEntity $item */
        $item = $this->_table()->get(1);

        isSame('Some name', $item->elements->find('_name.name'));
    }

    public function testEntityName()
    {
        /** @var ItemEntity $item */
        $item = $this->_table()->get(1);

        isSame('item', $item->getEntityName());
    }

    public function testSaveEvents()
    {
        $this->app->on('entity.item.save.before', function (App $app, ItemEntity $item) {
            $item->name = '456';
        });

        $this->app->on('entity.item.save.after', function (App $app, ItemEntity $item) {
            $item->name = '789';
        });


        /** @var ItemEntity $item */
        $item       = $this->_table()->get(1);
        $item->name = '123';

        $item->save();
        isSame('789', $item->name); // Changed in save.after

        $this->_table()->unsetObject(1);
        $itemAnotherInstance = $this->_table()->get(1);
        isSame('456', $itemAnotherInstance->name); // Real value in DB

        isNotSame($item, $itemAnotherInstance);
    }
}
