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
 * @codingStandardsIgnoreFile
 */

/*
Plugin Name: JBZoo CCK
Description: JBZoo Content Construction Kit (CCK)
Author: JBZoo Team <admin@jbzoo.com>
Version: 3.x-dev
Author URI: http://jbzoo.com
License: Proprietary http://jbzoo.com/license
*/

use JBZoo\CCK\App;
use JBZoo\CrossCMS\AbstractEvents;

if (!function_exists('dump')) {
    /**
     * Overload Symfony dump() function
     * @return mixed
     */
    function dump()
    {
        return call_user_func_array('jbd', func_get_args());
    }
}

/**
 * Init JBZoo Autoloader and general events for CMS
 * @throws Exception
 */
function JBZooInitAutoload()
{
    $initPath     = __DIR__ . '/jbzoo/init.php';
    $initRealPath = realpath($initPath);

    if ($initRealPath) {
        require_once $initRealPath;
    } else {
        throw new \Exception('Init file not found: ' . $initPath);
    }

    $app = App::getInstance();
    $app['assets']->add(null, 'assets:less/admin.less');

    // Hack for admin menu
    $app->on(AbstractEvents::EVENT_HEADER, function (App $app) {
        $app->trigger('jbzoo.assets');
    });

    add_action('wp_loaded', function () use ($app) {
        $app->trigger(AbstractEvents::EVENT_INIT);
    });

    // Header render
    add_action($app['env']->isAdmin() ? 'admin_footer' : 'wp_footer', function () use ($app) {
        $app->trigger(AbstractEvents::EVENT_HEADER);
    });

    // Content handlers (for macroses)
    add_filter('the_content', function ($content) use ($app) {
        $app['events']->filterContent($content);
        return $content;
    });

    // Shutdown callback
    add_action('shutdown', function () use ($app) {
        $app->trigger(AbstractEvents::EVENT_SHUTDOWN);
    });

    // Add admin dashboard and page
    add_action('admin_menu', function () {
        add_menu_page('JBZoo CCK', 'JBZoo CCK', 'manage_options', 'jbzoo', function () {
            require_once __DIR__ . '/jbzoo/jbzoo.php';
        }, 'dashicons-admin-jbzoo', 9);
    }, 8);
}

define('JBZOO', true);
define('JBZOO_EXT_PATH', 'wp-content/plugins/jbzoocck/jbzoo'); // TODO: remove hardcode to fix dev symlinks
define('JBZOO_AJAX_URL', site_url() . '/wp-admin/admin.php?page=jbzoo');

// Start!
JBZooInitAutoload();
