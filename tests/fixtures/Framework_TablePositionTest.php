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
    '#__jbzoo_positions' => [
        [
            'id'     => 1,
            'layout' => 'item.test',
            'params' => jbdata([
                'title' => [
                    [
                        '_name'  => [
                            'type'  => 'name',
                            'group' => 'item',
                        ],
                        '_alias'  => [
                            'type'  => 'alias',
                            'group' => 'item',
                        ],
                    ]
                ]
            ]),
        ],
        [
            'id'     => 2,
            'layout' => 'item.custom',
            'params' => jbdata([
                'properties' => [
                    [
                        '_name'  => [
                            'type'  => 'name',
                            'group' => 'item',
                        ],
                        '_alias'  => [
                            'type'  => 'alias',
                            'group' => 'item',
                        ],
                    ]
                ],
                'title' => [
                    [
                        '_name'  => [
                            'type'  => 'name',
                            'group' => 'item',
                        ],
                    ]
                ],
            ]),
        ],
    ]
];
