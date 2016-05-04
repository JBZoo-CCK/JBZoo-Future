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
 * Run the install scripts upon plugin activation
 */
function JBZoo_createTable()
{
    global $wpdb;
    global $your_db_name;

    $tableName = $wpdb->prefix . 'jbzoo_config';

    // create the ECPT metabox database table
    if ($wpdb->get_var("show tables like '{$your_db_name}'") != $tableName) {

        $sql = "CREATE TABLE `{$tableName}` (
                `option` VARCHAR(250) NOT NULL DEFAULT '',
                `value` LONGTEXT NOT NULL,
                `autoload` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
                UNIQUE INDEX `option_name` (`option`),
                INDEX `autoload` (`autoload`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * Init JBZoo Autoloader and general events for CMS
 * @throws Exception
 */
function JBZoo_initAutoload()
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

    if (isset($_REQUEST['page'])
        && $_REQUEST['page'] == 'jbzoo'
        && $_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
        add_action('admin_init', function () {
            require_once __DIR__ . '/jbzoo/jbzoo.php';
        });
    }

    // Add admin dashboard and page
    add_action('admin_menu', function () {
        add_menu_page('JBZoo CCK', 'JBZoo CCK', 'manage_options', 'jbzoo', function () {
            require_once __DIR__ . '/jbzoo/jbzoo.php';
        }, 'dashicons-admin-jbzoo', 9);
    }, 8);

    register_activation_hook(__FILE__, 'JBZoo_createTable');
}

define('JBZOO', true);
define('JBZOO_EXT_PATH', 'wp-content/plugins/jbzoocck/jbzoo'); // TODO: remove hardcode to fix dev symlinks
define('JBZOO_AJAX_URL', site_url() . '/wp-admin/admin.php?page=jbzoo');

// Start!
JBZoo_initAutoload();
