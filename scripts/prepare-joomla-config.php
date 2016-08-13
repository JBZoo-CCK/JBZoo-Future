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
 * @link      https://github.com/JBZoo/CCK
 */

use JBZoo\Utils\FS;

require_once __DIR__ . '/../vendor/autoload.php';

$configPath = FS::real('./resources/cck-joomla/configuration.php');

if ($configPath) {
    $config = FS::openFile($configPath);

    $config = preg_replace('#\'smtp\'#ius', "'mail'", $config);
    $config = preg_replace('#\'default\'#ius', "'development'", $config);
    $config = str_replace('public $live_site = \'\';', 'public $live_site = \'http://localhost:8881/\';', $config);
    $config = str_replace('public $session_handler = \'database\';', 'public $session_handler = \'none\';', $config);

    file_put_contents($configPath, $config);

} else {
    throw new \Exception('Joomla configuration file not found!');
}
