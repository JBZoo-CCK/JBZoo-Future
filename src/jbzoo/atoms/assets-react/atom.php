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

        $list = ['atom-assets-react:assets\js\react.min.js'];

        if (0) {
            $list = [
                'https://cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react.js',
                //'https://cdnjs.cloudflare.com/ajax/libs/react/0.14.7/react-with-addons.js',
                'https://cdnjs.cloudflare.com/ajax/libs/react/15.0.1/react-dom.js',
            ];
        }

        $app['assets']->register(
            'react-fonts',
            'var WebFontConfig = {
                google: { families: [ \'Roboto:400,300,500:latin\' ] }
            };
            (function() {
                var wf = document.createElement(\'script\');
                wf.src = (\'https:\' == document.location.protocol ? \'https\' : \'http\') +
                \'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js\';
                wf.type = \'text/javascript\';
                wf.async = \'true\';
                var s = document.getElementsByTagName(\'script\')[0];
                s.parentNode.insertBefore(wf, s);
            })();',
            [],
            ['type' => Asset::TYPE_JS_CODE]
        );

        $app['assets']->register('react', $list, ['react-fonts']);
    },
];
