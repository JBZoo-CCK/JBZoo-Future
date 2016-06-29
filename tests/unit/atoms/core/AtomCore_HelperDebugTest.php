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
 * Class AtomCore_HelperDebugTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class AtomCore_HelperDebugTest extends JBZooPHPUnit
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
        $uniq = uniqid();

        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';

        jbd()->trace(true);
        jbd()->logArray(['key' => $uniq]);
        isFile($logFile);
        isContain($uniq, file_get_contents($logFile));
    }
}
