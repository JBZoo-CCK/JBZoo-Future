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
if ($autoloadPath = realpath('./vendor/autoload.php')) {                    // developer mode
    require_once $autoloadPath;

} elseif ($autoloadPath = realpath('./src/jbzoo/vendor/autoload.php')) {    // production mode
    require_once $autoloadPath;

} else {
    echo 'Please execute "composer update" !' . PHP_EOL;
    exit(1);
}
