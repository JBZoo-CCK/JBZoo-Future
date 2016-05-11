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
    'test' => [
        'action' => 'test.index.index',
        'jsx'    => 'TestIndexIndex',
        'menu'   => jbt('Test'),
        'childs' => [
            ':module' => [
                'action' => 'test.index.module',
                'jsx'    => 'TestIndexModule',
                'menu'   => jbt('Test module')
            ],
            'page'    => [
                'action' => 'test.index.page',
                'jsx'    => 'TestIndexPage',
                'menu'   => jbt('Test page')
            ]
        ]
    ]
];
