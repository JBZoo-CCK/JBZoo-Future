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
 *
 * @codingStandardsIgnoreFile
 */

use JBZoo\CCK\App;

define('JBZOO_TABLE_ITEMS', '#__jbzoo_items');

return [

    'load' => function (App $app) {
        $app['models']->addModel('Items', 'Item');
    },

    'admin-sidebar' => [
        [
            'path'   => '/items',
            'name'   => 'Items',
            'childs' => [
                [
                    'path' => '/items/edit-positions',
                    'name' => 'Edit positions',
                ]
            ]
        ]
    ],

];
