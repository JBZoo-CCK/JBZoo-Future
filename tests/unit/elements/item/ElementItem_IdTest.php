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
 * Class ElementItem_IdTest
 */
class ElementItem_IdTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('id', 'item');
        isClass('\JBZoo\CCK\Element\Item\Id', $element);
    }

    public function testSave()
    {
        $itemData = [
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);

        isFalse($item->getElement('_id')->hasValue());
        isTrue($item->isNew());

        $item->save();

        isTrue($item->getElement('_id')->hasValue());
        isFalse($item->isNew());
    }
}
