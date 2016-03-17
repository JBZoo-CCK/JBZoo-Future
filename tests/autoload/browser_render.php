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

// Set global paths
$_SERVER['DOCUMENT_ROOT']   = realpath(CMS_PATH);
$_SERVER['SCRIPT_FILENAME'] = realpath(CMS_PATH . '/index.php');

ob_start();

if ($_SERVER['SCRIPT_FILENAME']) {
    include $_SERVER['SCRIPT_FILENAME'];
} else {
    throw new Exception('Invalid const "CMS_PATH". CMS index file not found!');
}

$cmsResult = ob_get_contents();
ob_end_clean();


\JBZoo\PHPUnit\cliMessage($cmsResult);
unset($cmsResult);
