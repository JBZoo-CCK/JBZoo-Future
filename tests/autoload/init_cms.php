<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CCK
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

// You can overwrite it by phpunit.xml
!defined('CMS_TYPE')      && define('CMS_TYPE',      'undefined');
!defined('CMS_JOOMLA')    && define('CMS_JOOMLA',    realpath(__DIR__ . '/../../resources/cck-joomla'));
!defined('CMS_WORDPRESS') && define('CMS_WORDPRESS', realpath(__DIR__ . '/../../resources/cck-wordpress'));

if (__CMS__ === 'joomla') {
    define('CMS_PATH', CMS_JOOMLA);
} elseif (__CMS__ === 'wordpress') {
    define('CMS_PATH', CMS_WORDPRESS);
} else {
    throw new \Exception('const CMS_TYPE is not defined!');
}
