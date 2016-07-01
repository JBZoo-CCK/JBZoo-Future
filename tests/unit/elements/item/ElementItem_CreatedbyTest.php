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
 * Class ElementItem_CreatedByTest
 */
class ElementItem_CreatedByTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Createdby', 'item');
        isClass('\JBZoo\CCK\Element\Item\Createdby', $element);
    }

    public function testSave()
    {
        $currentUser = $this->app['user']->getCurrent()->getId();

        $itemData = [
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);
        is($currentUser, $item->created_by);

        $item->save();

        $item->created_by = 111;
        isTrue($item->getElement('_createdby')->hasValue());

        is(111, $item->created_by);
        $item->save();
        is(111, $item->created_by);
    }
}
