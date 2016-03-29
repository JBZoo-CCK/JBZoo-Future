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
use JBZoo\Utils\FS;
use JBZoo\Utils\Url;

return [

    'events' => [

        // TODO: Add cutsom filters for Assets helper (join, compress, mdata, resolver, path rewriter)
        'jbzoo.assets' => function (App $app) {
            $app->trigger('atom.assets.header.before');

            // Vars
            $echoResult  = [];
            $rootJBZoo   = $app['path']->get('jbzoo:');
            $rootGlobal  = $app['path']->get('root:');
            $resolvePath = function ($fullPath) use ($rootJBZoo, $rootGlobal) {

                if (!Url::isAbsolute($fullPath)) {

                    $mtime = substr(filemtime($fullPath), -3);

                    $relPath = FS::getRelative($fullPath, $rootJBZoo, '/', false);

                    if (FS::clean('/' . $relPath) !== FS::clean('/' . $fullPath)) {
                        $fullPath = Url::buildAll(Url::root(), [
                            'path'  => '/' . JBZOO_EXT_PATH . '/' . $relPath,
                            'query' => 'mtime=' . $mtime,
                        ]);
                    } else {
                        $relPath  = FS::getRelative($fullPath, $rootGlobal, '/', true);
                        $fullPath = Url::buildAll(Url::root(), [
                            'path'  => '/' . $relPath,
                            'query' => 'mtime=' . $mtime,
                        ]);
                    }
                }

                return $fullPath;
            };

            // Resolve all dependencies for registered assets
            $list = $app['assets']->build();
            $app->trigger('atom.assets.build');


            // Include styles
            foreach ($list[Asset::TYPE_CSS_FILE] as $fullPath) {
                $app['header']->cssFile($resolvePath($fullPath));
            }

            // Include JS-scripts
            foreach ($list[Asset::TYPE_JS_FILE] as $fullPath) {
                if ($app['env']->isAdmin()) {
                    $echoResult[] = '<script type="text/javascript" src="' . $resolvePath($fullPath) . '"></script>';
                } else {
                    $app['header']->jsFile($resolvePath($fullPath));
                }
            }

            // Include JSX-scripts
            foreach ($list[Asset::TYPE_JSX_FILE] as $fullPath) {
                $echoResult[] = '<script type="text/babel" src="' . $resolvePath($fullPath) . '"></script>';
            }

            // Print plain CSS code
            foreach ($list[Asset::TYPE_CSS_CODE] as $cssCode) {
                $app['header']->cssCode($cssCode);
            }

            // Print plain JS code
            foreach ($list[Asset::TYPE_JS_CODE] as $jsCode) {
                $app['header']->jsCode($jsCode);
            }

            // Print plain JSX code
            foreach ($list[Asset::TYPE_JSX_CODE] as $jsxCode) {
                $echoResult[] = sprintf('<script type="text/babel">%s</script>', $jsxCode);
            }

            // TODO: Replace echo to CrossCMS helper
            echo PHP_EOL . PHP_EOL . implode(PHP_EOL, $echoResult) . PHP_EOL;

            $app->trigger('atom.assets.header.after');
        },
    ],
];
