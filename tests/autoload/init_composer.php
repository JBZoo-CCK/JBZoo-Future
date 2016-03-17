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

// main autoload
if ($composerPath = realpath('./composer.json')) {
    $autoloadConfig = json_decode(file_get_contents($composerPath), true);

    $vendor = 'vendor';
    if (isset($autoloadConfig['config']['vendor-dir'])) {
        $vendor = $autoloadConfig['config']['vendor-dir'];
    }

    require_once './' . $vendor . '/autoload.php';

} else {
    echo 'Please execute "composer update" !' . PHP_EOL;
    exit(1);
}
