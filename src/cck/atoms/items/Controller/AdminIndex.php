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

/**
 * Class AdminIndex
 * @package JBZoo\CCK
 */
class AdminIndex extends AdminController
{
    /**
     * @var array
     */
    protected $_items = [
        1 => [
            'id'     => 1,
            'name'   => 'Item name 1',
            'status' => 1,
        ],
        2 => [
            'id'     => 2,
            'name'   => 'Item name 2',
            'status' => 0,
        ]
    ];

    /**
     * Get list action
     */
    public function getList()
    {
        $this->_json(['list' => $this->_items]);
    }

    /**
     * Get item action
     */
    public function getItem()
    {
        $id = $this->app['request']->getJSON('id');

        $item = isset($this->_items[$id]) ? $this->_items[$id] : false;

        $this->_json(['item' => $item]);
    }
}
