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
 * Class TestAtomHelperTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class TestAtomHelperTest extends JBZooPHPUnit
{
    public function testGetHelper()
    {
        isTrue($this->app['test.test']->getRand() >= 1000);
        isTrue($this->app['atoms']['test']['test']->getRand() >= 1000);
    }
}
