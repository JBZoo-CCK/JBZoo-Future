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
use JBZoo\CCK\Exception;

/**
 * Class ElementItem_AliasTest
 */
class ElementItem_AliasTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Alias', 'item');
        isClass('\JBZoo\CCK\Element\Item\Alias', $element);
    }

    public function testSave()
    {
        $itemData = [
            'name' => 'Some name !@#$%^&*()_+ 1234567890-w {} \"\'',
            'type' => 'for-validation'
        ];

        $item = new Item($itemData);
        isTrue($item->save() > 0);
        isSame('some-name-1234567890-w', $item->alias);

        isTrue($item->save() > 0);
        isSame('some-name-1234567890-w', $item->alias);

        $item->alias = 'qwerty-1';
        isTrue($item->save() > 0);
        isSame('qwerty-1', $item->alias);

        $newItem        = new Item($itemData);
        $newItem->alias = 'qwerty-1';

        isTrue($newItem->save() > 0);
        isSame('qwerty-2', $newItem->alias);
    }

    public function testSaveExistedAlias()
    {
        $itemData = [
            'name'  => 'Some name',
            'type'  => 'for-validation',
            'alias' => 'some-name-1234567890',
        ];

        $item = new Item($itemData);
        isTrue($item->save() > 0);

        $item2 = new Item($itemData);

        try {
            $item2->save();
        } catch (Exception $e) {
            $errors = $e->getExtra();

            isTrue(is_array($errors));
            isTrue(isset($errors['_alias']));
        }
    }

    public function testSaveInvalidAlias()
    {
        $itemData = [
            'name'  => 'Some name',
            'type'  => 'for-validation',
            'alias' => 'some-name-1234567890',
        ];

        $item = new Item($itemData);
        $item->save();

        $item->alias = '"№;%:?*(qwerty';

        try {
            $item->save();
        } catch (Exception $e) {
            $errors = $e->getExtra();

            isTrue(is_array($errors));
            isTrue(isset($errors['_alias']));
        }
    }
}
