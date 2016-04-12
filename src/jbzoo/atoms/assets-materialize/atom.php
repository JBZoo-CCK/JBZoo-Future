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

use JBZoo\Assets\Asset\Asset;
use JBZoo\CCK\App;

return [
    'init' => function (App $app) {

        $app['assets']
            ->register(
                'materialize-fonts',
                'https://fonts.googleapis.com/icon?family=Material+Icons',
                [],
                ['type' => Asset::TYPE_CSS_FILE]
            )
            ->register(
                'materialize',
                [
                    'atom-assets-materialize:assets/css/materialize.min.css',
                    'atom-assets-materialize:assets/js/materialize.min.js',
                ],
                [
                    'jquery',
                    'materialize-fonts',
                ]
            );
    },
];
