<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

ob_start();

if ($basepath = realpath(getenv('PATH_JOOMLA'))) {
    $_SERVER['DOCUMENT_ROOT']   = $basepath;
    $_SERVER['SCRIPT_FILENAME'] = $basepath . '/index.php';

    require_once $basepath . '/index.php';

} elseif ($basepath = realpath(getenv('PATH_WORDPRESS'))) {
    $_SERVER['DOCUMENT_ROOT']   = $basepath;
    $_SERVER['SCRIPT_FILENAME'] = $basepath . '/index.php';

    require_once $basepath . '/index.php';

} else {
    throw new \Exception('Undefined CMS Type!');
}

$cmsResult = ob_get_contents();
ob_end_clean();

\JBZoo\PHPUnit\cliMessage($cmsResult);
unset($cmsResult);
