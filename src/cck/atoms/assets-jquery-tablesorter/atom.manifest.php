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

    'load' => function (App $app) {
        $app['assets']->register(
            'jquery-tablesorter',
            [
                'atom-assets-jquery-tablesorter:assets/js/tablesorter.min.js',
                'atom-assets-jquery-tablesorter:assets/css/tablesorter.min.css',
            ],
            'jquery'
        );
    },

];
