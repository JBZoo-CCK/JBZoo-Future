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
use JBZoo\Utils\FS;
use JBZoo\Utils\Url;

return [

    'events' => [
        'cms.header' => function (App $app) {

            $app->trigger('atom.assets.header');


            // Resolve all dependencies for registered assets
            $app->trigger('atom.assets.header.build.before');
            $list = $app['assets']->build();
            $app->trigger('atom.assets.header.build.after', [&$list]);

            // Include styles
            $app->trigger('atom.assets.header.css.before', [&$list['css']]);
            foreach ($list['css'] as $fullPath) {
                $file = $fullPath;
                if (!Url::isAbsolute($fullPath)) {
                    $file = FS::getRelative($fullPath);
                }

                $app['header']->cssFile($file);
            }
            $app->trigger('atom.assets.header.css.after');


            // Include JS-scripts
            $app->trigger('atom.assets.header.js.before', [&$list['js']]);
            foreach ($list['js'] as $fullPath) {
                $file = $fullPath;
                if (!Url::isAbsolute($fullPath)) {
                    $file = FS::getRelative($fullPath);
                }
                $app['header']->jsFile($file);
            }
            $app->trigger('atom.assets.header.js.before');
        },
    ],
];
