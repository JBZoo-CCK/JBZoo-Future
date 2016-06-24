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

namespace JBZoo\CCK\Atom\Items\Controller;

use JBZoo\CCK\Atom\AdminController;
use JBZoo\CCK\Entity\Item;

/**
 * Class AdminIndex
 * @package JBZoo\CCK
 */
class AdminIndex extends AdminController
{
    /**
     * Get list action
     */
    public function getList()
    {
        $items = $this->app['models']['item']->getList();

        $list = [];
        foreach ($items as $item) {
            $list[$item->id] = $item->toArray();
        }

        $this->_json(['list' => $list]);
    }

    /**
     * Get item action
     */
    public function getItem()
    {
        $id = $this->app['request']->getJSON('id');

        $item = $this->app['models']['item']->get($id);

        $this->_json(['item' => $item->toArray()]);
    }

    /**
     * Save item action
     */
    public function saveItem()
    {
        $itemData = $this->app['request']->getJSON('item');

        $item = new Item($itemData);

        $item->alias = mt_rand(0, 1000000);
        $item->save();

        $this->_json(['item' => $item->toArray()]);
    }

    /**
     * Save item action
     */
    public function removeItem()
    {
        $id = $this->app['request']->getJSON('id');

        /** @var Item $item */
        if ($item = $this->app['models']['item']->get($id)) {
            $item->remove();
        }

        $this->_json();
    }

    /**
     * Get new item action
     */
    public function getNewItem()
    {
        $item        = new Item();
        $item->alias = mt_rand(0, 1000000);

        $this->_json(['item' => $item->toArray()]);
    }
}
