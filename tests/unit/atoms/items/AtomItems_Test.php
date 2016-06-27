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
 * Class AtomItems_Test
 */
class AtomItems_Test extends JBZooPHPUnit
{
    public function testSaveItem()
    {
        $uniqName = uniqid('name-');

        $request = [
            'item' => [
                'name' => $uniqName
            ]
        ];

        $response = $this->_requestAdmin('items.index.saveItem', $request, 'PAYLOAD');

        /** @var Item $newItem */
        $newItem = $this->app['models']['item']->get($response->find('item.id'));
        isSame($uniqName, $response->find('item.name'));
        isSame($uniqName, $newItem->name);
    }

    public function testGetItem()
    {
        $response = $this->_requestAdmin('items.index.getItem', ['id' => 2], 'PAYLOAD');

        is($response->find('item.id'), 2);
    }

    public function testGetListAction()
    {
        $response = $this->_requestAdmin('items.index.getList');

        isTrue(is_array($response->find('list')));
    }
}
