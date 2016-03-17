<?php
/*
Plugin Name: JBZoo CCK
Description: JBZoo Content Construction Kit (CCK)
Author: JBZoo Team <admin@jbzoo.com>
Version: 1.0
Author URI: http://jbzoo.com
*/

// @codingStandardsIgnoreFile

use JBZoo\CCK\App;
use JBZoo\Utils\FS;

/**
 * Init JBZoo Autoloader and general events for CMS
 * @throws Exception
 */
function JBZooInitAutoload()
{
    if ($initPath = realpath(__DIR__ . '/jbzoo/init.php')) {
        require_once $initPath;
    } else {
        throw new Exception('JBZoo init file not found!');
    }

    $app = App::getInstance();

    add_action('wp_loaded', function () use ($app) {
        $app->trigger('cms.init');
    });

    // Header render
    add_action($app['env']->isAdmin() ? 'admin_footer' : 'wp_footer', function () use ($app) {
        $app->trigger('cms.header');
    });

    // Content handlers (for macroses)
    add_filter('the_content', function ($content) use ($app) {
        $app['events']->filterContent($content);
        return $content;
    });

    // Shutdown callback
    add_action('shutdown', function () use ($app) {
        $app->trigger('cms.shutdown');
    });

    // Init CMS Paths
    $app->on('paths.init.after', function () use ($app) {
        $app['path']->set('jbzoo', FS::dirname(__FILE__));
    });

    // Add admin dashboard and page
    add_action('admin_menu', function () {

        add_object_page('JBZoo CCK', 'JBZoo CCK', 'manage_options', 'jbzoo', function () {
            echo App::getInstance()->execute();
        }, 'dashicons-admin-jbzoo');

    }, 8);
}

define('_JBZOO', true);
JBZooInitAutoload();
