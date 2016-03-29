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

        // TODO: Add cutsom filter for Assets helepr
        'jbzoo.assets' => function (App $app) {

            $app->trigger('atom.assets.header.before');

            $rootPath = $app['path']->getRoot();

            // Resolve all dependencies for registered assets
            $list = $app['assets']->build();

            // Include styles
            foreach ($list['css'] as $fullPath) {
                if (!Url::isAbsolute($fullPath)) {
                    $file     = FS::getRelative($fullPath, $rootPath, '/', false);
                    $fullPath = Url::root() . '/administrator/components/com_jbzoo/' . $file;
                }

                $app['header']->cssFile($fullPath);
            }

            // Include JS-scripts
            foreach ($list['js'] as $fullPath) {

                if (!Url::isAbsolute($fullPath)) {
                    $relatedPath = FS::getRelative($fullPath, $app['path']->get('jbzoo:'), '/', false);
                    $fullPath    = Url::buildAll(Url::root(), ['path' => '/' . JBZOO_EXT_PATH . '/' . $relatedPath]);
                }

                if ($app['env']->isAdmin()) {
                    echo '<script src="' . $fullPath . '" type="text/javascript"></script>' . PHP_EOL;
                } else {
                    $app['header']->jsFile($fullPath);
                }

            }

            $app->trigger('atom.assets.header.after');
        },
    ],
];
