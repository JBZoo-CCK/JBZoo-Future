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
        $app['assets']->register(
            'bootstrap',
            [
                'atom-assets-bootstrap:assets/js/bootstrap.min.js',
                'atom-assets-bootstrap:assets/css/bootstrap.min.css',
            ],
            'jquery'
        );
    },
];
