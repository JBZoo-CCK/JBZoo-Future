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

use JBZoo\CCK\App;

echo debug_print_backtrace();

/**
 * Class com_jbzooInstallerScript
 */
class Com_jbzooInstallerScript
{
    public function __call($name, $arguments)
    {
        echo PHP_EOL . '!' . $name . '!' . PHP_EOL;
    }
}
