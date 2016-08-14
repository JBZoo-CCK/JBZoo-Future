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

defined('_JEXEC') or die('Restricted access');

if (!defined('JBZOO')) {
    throw new Exception('"JBZoo CCK" plugin is disabled!');
}

echo require_once __DIR__ . '/cck/index.php';
