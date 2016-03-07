<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CCK
 * @license   Proprietary http://jbzoo.com/license
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      http://jbzoo.com
 */

use JBZoo\CCK\App;

return [
    'init' => function (App $app) {
        $app['assets']->register(
            'jquery-ui',
            'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js', ['jquery-ui-css']
        );

        $app['assets']->register(
            'jquery-ui-css',
            'https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css', ['jquery']
        );
    },
];
