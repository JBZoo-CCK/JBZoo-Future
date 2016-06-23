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

use JBZoo\CCK\Atom\Items\Entity\Item;

/**
 * Class ItemsAtomTableItemsTest
 */
class ItemsAtomTableItemsTest extends JBZooPHPUnitDatabase
{
    protected $_fixtureFile = 'ItemsAtomTableItems.php';

    protected function setUp()
    {
        parent::setUp();
        $this->_table()->cleanObjects();
    }

    /**
     * @return \JBZoo\CCK\Atom\Items\Table\Item
     */
    protected function _table()
    {
        return $this->app['models']['item'];
    }

    public function testClassName()
    {
        isClass('\JBZoo\CCK\Atom\Items\Table\Item', $this->_table());
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
        /** @var Item $item */
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
        /** @var Item $item */
        $item = $this->_table()->get(1);

        isSame([
            "id"           => "1",
            "name"         => "Item 1",
            "type"         => "",
            "alias"        => "item-1",
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
        /** @var Item $item */
        $item        = new Item();
        $item->name  = 'Item new';
        $item->alias = 'item-new';
        $item->save();

        is(4, $item->id);
        isSame('Item new', $item->name);
        isSame('item-new', $item->alias);

        /** @var Item $itemNew */
        $itemNew = $this->_table()->get(4);
        is(4, $itemNew->id);
        isSame('Item new', $itemNew->name);
        isSame('item-new', $itemNew->alias);
    }

    public function testUpdateItem()
    {
        /** @var Item $item */
        $item        = new Item();
        $item->name  = 'Item new';
        $item->alias = 'item-new';
        $item->save();

        is(4, $item->id);
        isSame('Item new', $item->name);
        isSame('item-new', $item->alias);

        $item->name = 'Another name';
        $item->save();

        $this->_table()->cleanObjects();
        /** @var Item $itemNew */
        $itemNew = $this->_table()->get(4);
        is(4, $itemNew->id);
        isSame('Another name', $itemNew->name);
        isSame('item-new', $itemNew->alias);
    }

    public function testGetUndefined()
    {
        $itemNew = $this->_table()->get(100500);
        isNull($itemNew);

        isFalse($this->_table()->hasObject(100500));
    }
}
