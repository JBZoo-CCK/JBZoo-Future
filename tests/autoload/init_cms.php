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

use JBZoo\Utils\Env;

// You can overwrite it by phpunit.xml
!defined('JOOMLA')           && define('JOOMLA', 'joomla');
!defined('WORDPRESS')        && define('WORDPRESS', 'wordpress');

!defined('CMS_TYPE')         && define('CMS_TYPE', 'undefined');
!defined('CMS_ADMIN_ID')     && define('CMS_ADMIN_ID', 1);
!defined('CMS_JOOMLA')       && define('CMS_JOOMLA', realpath(__DIR__ . '/../../resources/cck-joomla'));
!defined('CMS_WORDPRESS')    && define('CMS_WORDPRESS', realpath(__DIR__ . '/../../resources/cck-wordpress'));
!defined('PROJECT_FIXTURES') && define('PROJECT_FIXTURES', realpath(__DIR__ . '/../fixtures'));
!defined('WP_POST_ID')       && define('WP_POST_ID', 0);

define('PHPUNIT_JOOMLA_HOST',   Env::get('JOOMLA_HOST', 'cck-joomla.jbzoo',     Env::VAR_STRING));
define('PHPUNIT_WP_HOST',       Env::get('WP_HOST',     'cck-wordpress.jbzoo',  Env::VAR_STRING));
define('PHPUNIT_HTTP_USER',     Env::get('HTTP_USER',   '',                     Env::VAR_STRING));
define('PHPUNIT_HTTP_PASS',     Env::get('HTTP_PASS',   '',                     Env::VAR_STRING));

if (__CMS__ === JOOMLA) {
    define('CMS_PATH', CMS_JOOMLA);
    define('PHPUNIT_HTTP_HOST', PHPUNIT_JOOMLA_HOST);

} elseif (__CMS__ === WORDPRESS) {
    define('CMS_PATH', CMS_WORDPRESS);
    define('PHPUNIT_HTTP_HOST', PHPUNIT_WP_HOST);

} else {
    throw new \Exception('const CMS_TYPE is not defined!');
}
