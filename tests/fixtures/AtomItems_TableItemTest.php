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

return [
    '#__jbzoo_items' => [
        [
            'id'       => 1,
            'alias'    => 'item-1',
            'name'     => 'Item 1',
            'status'   => 1,
            'elements' => jbdata([
                '_name' => [
                    'name' => 'Some name'
                ],
            ])
        ],
        [
            'id'       => 2,
            'alias'    => 'item-2',
            'name'     => 'Item 2',
            'status'   => 1,
            'elements' => '',
        ],
        [
            'id'       => 3,
            'alias'    => 'item-3',
            'name'     => 'Item 3',
            'status'   => 0,
            'elements' => '',
        ],
    ],
];
