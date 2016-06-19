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

use JBZoo\CCK\App;

return [

    'meta' => [
        'name'        => 'Core',
        'description' => 'General configurations',
    ],

    'load' => function (App $app) {
        $app['models']->addModel('Core', 'Config');
    },

    'config' => [
        'debug' => [
            'type'        => 'group',
            'label'       => 'Debuging config',
            'description' => 'Show profiler, SQL-queries and var dumps and etc',
            'default'     => false,
            'childs'      => [
                'dumper'   => [
                    'type'    => 'select',
                    'hint'    => 'Dumper type',
                    'options' => [
                        'none'     => "Disable",
                        'symfony'  => "Symfony VarDumper",
                        'jbdump'   => "JBDump",
                        'var_dump' => "function var_dump()",
                    ],
                    'default' => 'symfony',
                ],
                'ip'       => [
                    'type'        => 'textarea',
                    'label'       => 'Debug IP',
                    'placeholder' => 'Only this IP list can see debug info',
                    'hint'        => 'One line is one address',
                    'default'     => implode(PHP_EOL, ["127.0.0.1", "192.168.0.1"]),
                ],
                'log'      => [
                    'type'    => 'toggle',
                    'hint'    => 'Log messages',
                    'default' => false,
                ],
                'dump'     => [
                    'type'    => 'toggle',
                    'hint'    => 'Show dumps of vars',
                    'default' => true,
                ],
                'sql'      => [
                    'type'    => 'toggle',
                    'hint'    => 'Show SQL-queries',
                    'default' => true,
                ],
                'profiler' => [
                    'type'    => 'toggle',
                    'hint'    => 'Show profiler',
                    'default' => true,
                ],
                'trace'    => [
                    'type'    => 'toggle',
                    'hint'    => 'Show backtraces for dumps',
                    'default' => false,
                ],
            ]
        ],
    ],
];
