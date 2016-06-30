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

use JBZoo\CCK\Entity\Exception;
use JBZoo\CCK\Entity\Item;
use JBZoo\Utils\Str;

/**
 * Class ElementItem_NameTest
 */
class ElementItem_NameTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('name', 'item');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);
    }

    public function testSaveForAdmin()
    {
        $itemData = [
            'name' => Str::random(300),
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);
        is(2, $item->save());

        isSame(255, strlen($item->name));
        isSame(255, strlen($item->alias));
    }

    public function testSaveInvaliName()
    {
        $itemData = [
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);

        try {
            $item->save();
        } catch (Exception $e) {
            $errors = $e->getExtra();

            isTrue(is_array($errors));
            isTrue(isset($errors['_name']));
        }
    }
}
