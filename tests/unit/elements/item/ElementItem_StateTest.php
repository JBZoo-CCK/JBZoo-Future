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
 * Class ElementItem_StateTest
 */
class ElementItem_StateTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('State', 'item');
        isClass('\JBZoo\CCK\Element\Item\State', $element);
    }

    public function testSaveExistedAlias()
    {
        $itemData = [
            'state' => Item::STATUS_ARCHIVE,
            'type'  => 'for-validation'
        ];

        $item = new Item($itemData);
        $item->save();
        is(Item::STATUS_ARCHIVE, $item->state);


        $item->state = '100500';
        $item->save();
        is(Item::STATUS_UNACTIVE, $item->state);


        $item->state = Item::STATUS_ACTIVE;
        $item->save();
        is(Item::STATUS_ACTIVE, $item->state);
    }
}
