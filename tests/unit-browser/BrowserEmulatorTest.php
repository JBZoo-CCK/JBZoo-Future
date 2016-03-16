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

namespace JBZoo\PHPUnit;

/**
 * Class BrowserEmulatorTest
 * @package JBZoo\PHPUnit
 */
class BrowserEmulatorTest extends PHPUnit
{
    public function test()
    {
        require_once PROJECT_ROOT . '/tests/autoload/init_cms.php';
        require_once PROJECT_ROOT . '/tests/autoload/browser_render.php';

        isTrue(true); // phpunit hack
    }
}