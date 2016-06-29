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

    'events' => [

        'init.app.after.admin' => function (App $app) {
            $app['js']->addVar('csrf', $app['session']->getToken());
        },

        'request.ajax' => function (App $app) {

            $request = $app['request'];
            $session = $app['session'];

            if ($request->isPost()) {
                $xsrfToken = $request->getHeader('X-XSRF-Token');

                if (!$xsrfToken || $xsrfToken !== $session->getToken()) {
                    $app->error('Invalid CSRF token');
                }
            }
        },

    ],
];
