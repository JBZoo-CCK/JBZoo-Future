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
    '#__jbzoo_config' => [
        [
            'autoload' => 1,
            'option'   => 'type.some-type',
            'value'    => jbdata([
                'name'     => 'Type name',
                'elements' => [
                    '_name'              => [
                        'type'     => 'name',
                        'group'    => 'item',
                        'option-1' => 'Value 1',
                        'option-2' => 'Value 2'
                    ],
                    'test-id-random'     => [
                        'type'     => 'text',
                        'group'    => 'item',
                        'option-1' => 'Value 1',
                        'option-2' => 'Value 2'
                    ],
                    'no-valid-element-1' => [
                        'type'  => 'undefined',
                        'group' => 'undefined',
                    ],
                    'no-valid-element-2' => [
                        'type'  => '',
                        'group' => 'undefined',
                    ],
                    'no-valid-element-3' => [
                        'type'  => 'undefined',
                        'group' => '',
                    ],
                ]
            ]),
        ],
        [
            'autoload' => 1,
            'option'   => 'type.elements',
            'value'    => jbdata([
                'name'     => 'Type with elements',
                'elements' => [
                    '_name'           => [
                        'type'  => 'name',
                        'group' => 'item',
                    ],
                    '_status'         => [
                        'type'  => 'created',
                        'group' => 'item',
                    ],
                    'text-reandom-id' => [
                        'type'  => 'text',
                        'group' => 'item',
                    ],
                ]
            ]),
        ],
    ],
];
