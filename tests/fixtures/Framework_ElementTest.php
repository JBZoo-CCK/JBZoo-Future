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
            'id'       => 1,
            'alias'    => 'item-1',
            'name'     => 'Item 1',
            'state'    => 1,
            'type'     => 'post',
            'elements' => jbdata([
                'some-repeatable' => [
                    0 => [
                        'value' => 'Value #1'
                    ],
                    1 => [
                        'value' => 'Value #2'
                    ],
                    2 => [
                        'value' => 'Value #3'
                    ],
                ],
                'some-rep-empty'  => [
                ],
                'some-test'       => [
                    'value' => 'Value'
                ],
            ])
        ],
    ],
    '#__jbzoo_config' => [
        [
            'option' => 'type.post',
            'value'  => jbdata([
                'elements' => [
                    'some-repeatable' => [
                        'id'    => 'some-repeatable',
                        'type'  => 'testrepeatable',
                        'group' => 'item'
                    ],
                    'some-rep-empty'  => [
                        'id'    => 'some-rep-empty',
                        'type'  => 'testrepeatable',
                        'group' => 'item'
                    ],
                    'some-test'       => [
                        'id'    => 'some-test',
                        'type'  => 'test',
                        'group' => 'item'
                    ],
                ],
            ])
        ],
    ],
];
