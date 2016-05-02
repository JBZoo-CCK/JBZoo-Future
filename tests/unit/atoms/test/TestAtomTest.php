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
 * Class TestAtomTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class TestAtomTest extends JBZooPHPUnit
{
    public function testRequestedControllerEchoGET()
    {
        $uniq = uniqid('var');

        $this->app['request']->set('qwerty', $uniq);

        $actual = $this->app->execute('test.other.' . strtolower('checkEcho')); // check case-insensetive

        isSame($uniq, $actual);
        isSame($uniq, $_GET['qwerty']);
    }

    public function testGetResultOfController()
    {
        isSame(123456, $this->app->execute('test.index.checkReturn'));
    }
}
