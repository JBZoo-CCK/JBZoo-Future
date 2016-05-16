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
 *
 * @codingStandardsIgnoreFile
 *
 *
 * Plugin Name: JBZoo CCK
 * Description: JBZoo Content Construction Kit (CCK)
 * Author: JBZoo Team <admin@jbzoo.com>
 * Version: 3.x-dev
 * Author URI: http://jbzoo.com
 * License: Proprietary http://jbzoo.com/license
 *
 * Text Domain: jbzoo
 * Domain Path: /languages/
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
function JBZoo_initAutoload()
{
    define('JBZOO_PATH', 'wp-content/plugins/jbzoo/cck'); // TODO: remove hardcode to fix dev symlinks
    define('JBZOO_AJAX_URL', site_url() . '/wp-admin/admin.php?page=jbzoo');

    $indexPath = realpath(__DIR__ . '/cck/index.php');
    require_once __DIR__ . '/cck/init.php';

    // Init JBZoo Application
    $app = App::getInstance();
    $app['assets']->add(null, 'assets:less/admin.less');

    $isAdmin = $app['env']->isAdmin();

    // Hack for admin menu
    $app->on(AbstractEvents::EVENT_HEADER, function (App $app) {
        $app->trigger('jbzoo.assets');
    });

    // Render front end
    $app->on(AbstractEvents::EVENT_CONTENT, function (App $app, &$content) use ($indexPath) {

        static $jbzooContent;

        $macross = '[jbzoo]';
        if (stripos($content, $macross) !== false) {
            if (null === $jbzooContent) {
                $jbzooContent = include $indexPath;
            }

            $content = preg_replace('#' . preg_quote($macross) . '#ius', $jbzooContent, $content);
        }
    });

    // Render ajax for back end (hack)
    if (isset($_REQUEST['page']) && $_REQUEST['page'] === 'jbzoo') {
        if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST') {
            add_action('admin_init', function () use ($indexPath) {
                echo include $indexPath;
            });
        } else {
            add_action('init', function () use ($indexPath) {
                echo include $indexPath;
            });
        }
    }

    #### Subscribe to Wordpress hooks ##################################################################################

    add_action('wp_loaded', function () use ($app) {
        $app->trigger(AbstractEvents::EVENT_INIT);
    });

    // Header render
    add_action($isAdmin ? 'admin_footer' : 'wp_footer', function () use ($app) {
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

    // Add admin dashboard and admin page
    add_action('admin_menu', function () use ($indexPath) {
        add_menu_page('JBZoo CCK', 'JBZoo CCK', 'manage_options', 'jbzoo', function () use ($indexPath) {
            echo include $indexPath;
        }, 'dashicons-admin-jbzoo', 9);
    }, 8);

    // Install
    register_activation_hook(__FILE__, function () use ($app) {
        $app['atoms']['core']['installer']->install();
    });

    // Uninstall
    register_deactivation_hook(__FILE__, function () use ($app) {
        $app['atoms']['core']['installer']->uninstall();
    });
}

// Start!
JBZoo_initAutoload();
