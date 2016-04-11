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

        $app['assets']->register(
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

        $cssCode = '/* fallback */
            @font-face {
              font-family: \'Material Icons\';
              font-style: normal;
              font-weight: 400;
              src: local(\'Material Icons\'), local(\'MaterialIcons-Regular\'), url(http://fonts.gstatic.com/s/materialicons/v14/2fcrYFNaTjcS6g4U3t-Y5ZjZjT5FdEJ140U2DJYC3mY.woff2) format(\'woff2\');
            }

            .material-icons {
              font-family: \'Material Icons\';
              font-weight: normal;
              font-style: normal;
              font-size: 24px;
              line-height: 1;
              letter-spacing: normal;
              text-transform: none;
              display: inline-block;
              white-space: nowrap;
              word-wrap: normal;
              direction: ltr;
              -webkit-font-feature-settings: \'liga\';
              -webkit-font-smoothing: antialiased;
            }
        ';

        $app['assets']->register('materialize-fonts', $cssCode, [], ['type' => Asset::TYPE_CSS_CODE]);
    },
];
