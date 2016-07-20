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
    '#__jbzoo_items'  => [
        [
            'id'         => 1,
            'name'       => 'Name of test',
            'type'       => 'item-type',
            'alias'      => 'test-alias',
            'status'     => 1,
            'publish_up' => '2016-01-01 00:00:00',
            'elements'   => jbdata([
                'some-test'   => ['value' => 'Some test words'],
                'custom-el'   => ['value' => ''],
                'custom-el-2' => ['value' => null],
                'custom-el-3' => ['value' => false],
                'custom-el-4' => ['value' => 2],
                'custom-el-5' => ['value' => 0],
            ])
        ],
    ],
    '#__jbzoo_config' => [
        [
            'option' => 'render.item-type.full',
            'value'  => jbdata([
                'title' => [
                    [
                        'id' => '_name',
                        'showlabel' => 0,
                        'altlabel' => null,
                    ],
                    [
                        'id' => 'some-test',
                        'showlabel' => 1,
                        'altlabel' => null,
                    ],
                ],
                'properties' => [
                    [
                        'id' => '_status',
                        'showlabel' => 1,
                        'altlabel' => '',
                    ],
                ],
                'content' => [
                    [
                        'id' => 'some-test',
                        'showlabel' => 1,
                        'altlabel' => 'Custom alt label',
                    ]
                ],
                'bottom' => [
                    [
                        'id' => 'custom-el',
                        'showlabel' => 0,
                        'altlabel' => 'Custom alt label',
                    ]
                ],
                'scope' => [
                    [
                        'id' => 'custom-el',
                        'showlabel' => 0,
                        'altlabel' => 'Custom alt label',
                    ],
                    [
                        'id' => 'custom-el-2',
                        'showlabel' => 0,
                        'altlabel' => 'Custom alt label',
                    ],
                    [
                        'id' => 'custom-el-3',
                        'showlabel' => 0,
                        'altlabel' => 'Custom alt label',
                    ],
                ],
                'one-of-two' => [
                    [
                        'id' => 'custom-el-3',
                        'showlabel' => 0,
                        'altlabel' => 'Custom alt label',
                    ],
                    [
                        'id' => 'custom-el-4',
                        'showlabel' => 1,
                        'altlabel' => ' ',
                    ],
                ]
            ]),
        ],
        [
            'option' => 'type.item-type',
            'value'  => jbdata([
                'elements' => [
                    'some-test' => [
                        'id'    => 'some-test',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                    'custom-el' => [
                        'id'    => 'custom-el',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                    'custom-el-2' => [
                        'id'    => 'custom-el-2',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                    'custom-el-3' => [
                        'id'    => 'custom-el-3',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                    'custom-el-4' => [
                        'id'    => 'custom-el-4',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                    'custom-el-5' => [
                        'id'    => 'custom-el-5',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                ],
            ])
        ],
    ],
];
