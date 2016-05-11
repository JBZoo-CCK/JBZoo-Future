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
    '/'      => [
        'action' => 'core.index.index',
        'jsx'    => '../../../core/assets/jsx/pages/CoreIndexIndex',
        'menu'   => jbt('Dashboard')
    ],
    '/about' => [
        'action' => 'core.index.about',
        'jsx'    => 'CoreIndexAbout',
        'menu'   => jbt('About')
    ]
];
