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

define('ABSPATH', CMS_PATH . DS);

define('WP_USE_EXT_MYSQL', false);
define('WP_DEBUG_DISPLAY', true);
define('WP_INSTALLING', true);
define('SAVEQUERIES', false);
define('WP_CACHE', false);

define('WP_TESTS_TABLE_PREFIX', false);
define('WP_TESTS_FORCE_KNOWN_BUGS', false);
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', -1);
define('WP_MAX_MEMORY_LIMIT', -1);
define('WP_TESTS_DOMAIN', 'domain.com');

/*
 * Globalize some WordPress variables, because PHPUnit loads this file inside a function
 * See: https://github.com/sebastianbergmann/phpunit/issues/325
 */
global $wpdb, $current_site, $current_blog, $wp_rewrite, $shortcode_tags, $wp, $phpmailer;

require_once ABSPATH . 'wp-config.php';
