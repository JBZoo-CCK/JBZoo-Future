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
 * Class ElementItem_CreatedTest
 */
class ElementItem_CreatedTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Created', 'item');
        isClass('\JBZoo\CCK\Element\Item\Created', $element);
    }

    public function testHasValue()
    {
        $itemData = [
            //'name' => 'Some name',
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);
        isFalse($item->getElement('_created')->hasValue());

        $item->save();

        isTrue($item->getElement('_created')->hasValue());
    }

    public function testSaveForAdmin()
    {
        $currentDate = $this->app['date']->format(time(), 'sql');

        $itemData = [
            'name'    => 'Some name',
            'type'    => 'for-validation',
            'created' => $currentDate,
        ];

        $item = new Item($itemData);
        $item->save();

        is($currentDate, $item->created);
    }
}
