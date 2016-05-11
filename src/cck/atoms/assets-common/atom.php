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
    'init' => function (App $app) {

        $list = [
            'atom-assets-common:assets/css/assets-common.min.css',
            'atom-assets-common:assets/js/assets-common.min.js',
        ];

        if ($app['env']->isAdmin()) {
            $app['assets']->add('common', $list);
        } else {
            $app['assets']->register('common', $list);
        }
    },
];
