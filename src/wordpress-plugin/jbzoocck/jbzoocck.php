<?php
/*
Plugin Name: JBZoo CCK
Description: JBZoo Content Construction Kit (CCK)
Author: JBZoo Team <admin@jbzoo.com>
Version: 1.0
Author URI: http://jbzoo.com
*/

// Init
use JBZoo\CCK\App;
use JBZoo\Utils\FS;

define('_JBZOO', true);

/**
 * Init JBZoo Autoloader and general events for CMS
 */
function JBZooInitAutoload()
{
    /** @var App $app */
    $app = require_once __DIR__ . '/jbzoo/init.php';

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
            App::getInstance()->execute();
        }, 'dashicons-admin-jbzoo');

    }, 8);
}

JBZooInitAutoload();
