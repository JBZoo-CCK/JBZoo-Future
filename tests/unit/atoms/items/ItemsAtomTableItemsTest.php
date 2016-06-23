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

/**
 * Class ItemsAtomTableItemsTest
 */
class ItemsAtomTableItemsTest extends JBZooPHPUnitDatabase
{
    protected $_fixtureFile = 'ItemsAtomTableItems.php';

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
        $item1 = $this->_table()->getById(1);
        $item2 = $this->_table()->getById(1);
        isSame($item1, $item2);
    }

    public function testUnset()
    {
        $item1 = $this->_table()->getById(1);
        $this->_table()->unsetObject(1);
        $item2 = $this->_table()->getById(1);

        isNotSame($item1, $item2);
    }

    public function testHasObject()
    {
        $this->_table()->cleanObjects();
        isFalse($this->_table()->hasObject(1));

        $this->_table()->getById(1);
        isTrue($this->_table()->hasObject(1));

        $this->_table()->unsetObject(1);
        isFalse($this->_table()->hasObject(1));
    }

    public function testGetList()
    {
        is(2, count($this->_table()->getList()));
    }
}
