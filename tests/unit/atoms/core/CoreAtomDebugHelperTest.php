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
 * Class CoreAtomDebugHelperTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class CoreAtomDebugHelperTest extends JBZooPHPUnit
{
    public function testGetHelper()
    {
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['atoms']['core']['debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['core.debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', jbd());

        isSame($this->app['atoms']['core']['debug'], jbd());
        isSame($this->app['atoms']['core']['debug'], $this->app['core.debug']); // Experimental
        isSame(jbd(), $this->app['core.debug']);
    }

    public function testTraceToLog()
    {
        jbd()->trace(true);
        jbd()->logArray(['key' => 'value']);
        isFile(PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php');
    }
}
