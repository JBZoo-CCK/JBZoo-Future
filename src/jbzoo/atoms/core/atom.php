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

    'meta' => [
        'name'        => 'Core',
        'description' => 'General configurations',
    ],

    'config' => [
        'debug'    => [
            'type'        => 'toggle',
            'label'       => 'Debug mode',
            'description' => 'Show profiler, SQL-queries and var dumps',
            'default'     => false,
        ],
        'debug_ip' => [
            'type'        => 'textarea',
            'label'       => 'Debug IP',
            'placeholder' => 'One line is one address',
            'description' => 'Only this IP list can see debug info',
            'default'     => implode(PHP_EOL, ["127.0.0.1", "192.168.0.1"]),
        ],
        'select' => [
            'type'        => 'select',
            'label'       => 'Select field',
            'description' => 'Select Lorem iing elit',
            'options'     => [
                '1' => "Never",
                '2' => "Every Night",
                '3' => "Weeknights",
                '4' => "Weekends",
                '5' => "Weekly",
            ],
            'default'     => 2,
        ],
    ],
];
