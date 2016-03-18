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

namespace JBZoo\PHPUnit;

/**
 * Class AtomTestTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class HelperDebugCoreTest extends JBZooPHPUnit
{
    public function testGetHelper()
    {
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['atoms']['core']['debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['core.debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', jbd());
        isClass('\JBZoo\CCK\Atom\Helper', $this->app['debug']);

        isSame($this->app['atoms']['core']['debug'], $this->app['debug']);
        isSame($this->app['atoms']['core']['debug'], $this->app['core.debug']);
        isSame($this->app['debug'], $this->app['core.debug']);
    }
}
