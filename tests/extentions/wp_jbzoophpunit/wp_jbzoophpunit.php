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
 * @SuppressWarnings(PHPMD.Superglobals)
 *
 * Plugin Name: JBZoo CCK - PHPUnit
 * Description: JBZoo PHPUnit Plugin for unit-testing
 * Author: JBZoo Team <admin@jbzoo.com>
 * Version: 1.0
 * Author URI: http://jbzoo.com
 */

if (isset($_REQUEST['jbzoo-phpunit'])) {

    if (isset($GLOBALS['__TEST_FUNC__']) && $GLOBALS['__TEST_FUNC__'] instanceof \Closure) {
        $GLOBALS['__TEST_FUNC__']();
    } else {
        throw new Exception('__TEST_FUNC__ is not \Closure function!');
    }
}
