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
 *
 * @codingStandardsIgnoreFile
 */

use JBZoo\CCK\App;

define('JBZOO_TABLE_MODULES', '#__jbzoo_modules');

return [

    'load' => function (App $app) {
        $app['models']->addModel('Modules', 'Module');
    },

    'admin-sidebar' => [
        [
            'path' => '/modules',
            'name' => 'Modules',
        ]
    ],

];
