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

use JBZoo\CCK\Entity\Item;

/**
 * Class ElementItem_ModifiedTest
 */
class ElementItem_ModifiedTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Modified', 'item');
        isClass('\JBZoo\CCK\Element\Item\Modified', $element);
    }

    public function testHasValue()
    {
        $itemData = ['type' => 'for-validation'];

        $item = new Item($itemData);
        isFalse($item->getElement('_modified')->hasValue());

        $item->save();

        isTrue($item->getElement('_modified')->hasValue());
    }

    public function testSave()
    {
        $currentDate = $this->app['date']->format(time(), 'sql');

        $itemData = ['type' => 'for-validation', 'modified' => $currentDate];

        $item = new Item($itemData);
        $item->save();

        is($currentDate, $item->modified);
    }

    public function testResave()
    {
        $itemData = ['type' => 'for-validation'];

        $item = new Item($itemData);

        isFalse($item->getElement('_modified')->hasValue());
        isFalse($item->getElement('_created')->hasValue());
        isSame($item->modified, $item->created);

        $item->save();

        isTrue($item->getElement('_modified')->hasValue());
        isTrue($item->getElement('_created')->hasValue());

        sleep(1);
        $item->save();

        isTrue($item->getElement('_modified')->hasValue());
        isTrue($item->getElement('_created')->hasValue());

        isNotSame($item->modified, $item->created);
    }
}
