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
            'jquery-fancybox',
            [
                'atom-assets-jquery-fancybox:assets/js/fancybox.min.js',
                'atom-assets-jquery-fancybox:assets/css/fancybox.min.css',
            ],
            'jquery'
        );
    },

];
