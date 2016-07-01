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
 * Class ElementItem_StatusTest
 */
class ElementItem_StatusTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Status', 'item');
        isClass('\JBZoo\CCK\Element\Item\Status', $element);
    }

    public function testSaveExistedAlias()
    {
        $itemData = [
            'status' => Item::STATUS_ARCHIVE,
            'type'   => 'for-validation'
        ];

        $item = new Item($itemData);
        $item->save();
        is(Item::STATUS_ARCHIVE, $item->status);


        $item->status = '100500';
        $item->save();
        is(Item::STATUS_UNACTIVE, $item->status);


        $item->status = Item::STATUS_ACTIVE;
        $item->save();
        is(Item::STATUS_ACTIVE, $item->status);
    }
}
