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
        'name'    => 'PHPUnit Atom',
        'desc'    => 'The best of atom by JBZoo Team!',
        'author'  => 'JBZoo.com',
        'licence' => 'http://jbzoo.com/license',
        'created' => '01/01/2016',
        'version' => '1.0.0',
    ],

    'config' => [
        'group' => [
            'type'        => 'group',
            'label'       => 'Grouped field',
            'description' => 'Lorem ipsum r adipiscing elit',
            'default'     => [
                'text1' => 123456,
                'text2' => 'qwerty',
            ],

            'childs' => [
                'text1' => [
                    'type'        => 'text',
                    'placeholder' => 'Name',
                    'hint'        => 'What is your name?',
                    'default'     => '',
                ],
                'text2' => [
                    'type'        => 'text',
                    'placeholder' => 'Name',
                    'hint'        => 'What is your name?',
                    'default'     => '',
                ],
            ]
        ],

        'text' => [
            'type'        => 'text',
            'label'       => 'Text field',
            'description' => 'Text Lorem amet, consectetur adipiscing elit',
            'placeholder' => 'Name',
            'hint'        => 'What is your name?',
            'default'     => '',
        ],

        'textarea' => [
            'type'        => 'textarea',
            'label'       => 'Textarea field',
            'description' => 'Textarea Lorem amet, consectetur adipiscing elit',
            'placeholder' => 'Name',
            'hint'        => 'What is your name?',
            'default'     => '',
        ],

        'toggle' => [
            'type'        => 'toggle',
            'label'       => 'Toggle field',
            'description' => 'Toggle Lorem ipsum dolor sit amet, colit',
            'hint'        => 'What is your name?',
            'default'     => true,
        ],

        'checkbox' => [
            'type'        => 'checkbox',
            'label'       => 'Checkbox field',
            'description' => 'Checkbox Lorem ipsum doloretur adipiscing elit',
            'hint'        => 'Is it enable?',
            'default'     => true,
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

        'radio' => [
            'type'        => 'radio',
            'label'       => 'Radio list',
            'description' => 'Radio Lorem ipsum dolctetur adipiscing elit',
            'options'     => [
                '1' => "First opt.",
                '2' => "Second option",
                '3' => "3 option",
            ],
            'default'     => 3,
        ],

        'date' => [
            'type'        => 'date',
            'label'       => 'Date',
            'description' => 'Date Lorem ipsum dolor sit amet',
            'default'     => '2016-04-22',
            'format'      => 'YYYY-MM-DD',
        ],

        'time' => [
            'type'        => 'time',
            'label'       => 'Time',
            'description' => 'Time Lorem ipsum dolor asd adas dasd asda amet',
            'default'     => '18:25',
        ],
    ]
];
