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
 * Class FunctionsTest
 * @package JBZoo\PHPUnit
 */
class FunctionsTest extends JBZooPHPUnit
{
    public function test_JBApp()
    {
        isClass('\JBZoo\CCK\App', jbzoo());
    }

    public function test_JBAppHelper()
    {
        isClass('\JBZoo\Path\Path', jbzoo('path'));
    }

    public function test_JBAtom()
    {
        isClass('\JBZoo\CCK\Atom\Core\Core', jbatom('core'));
        isClass('\JBZoo\CCK\Atom\Manager', jbatom());
    }

    public function test_JBData()
    {
        isClass('\JBZoo\Data\JSON', jbdata());

        $data  = jbdata();
        $data2 = jbdata($data);
        isSame($data, $data2);

        isSame('{"key":"value"}', json_encode(jbdata('{"key":"value"}')));
    }

    public function test_JBT()
    {
        isSame('undefined_test_message', jbt('undefined_test_message'));
    }
}
