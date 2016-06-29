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
 * Class Framework_FunctionsTest
 * @package JBZoo\PHPUnit
 */
class Framework_FunctionsTest extends JBZooPHPUnit
{
    public function testJbzoo()
    {
        isClass('\JBZoo\CCK\App', jbzoo());
    }

    public function testJbzooHelper()
    {
        isClass('\JBZoo\Path\Path', jbzoo('path'));
    }

    public function testJbatom()
    {
        isClass('\JBZoo\CCK\Atom\Core\Core', jbatom('core'));
        isClass('\JBZoo\CCK\Atom\Manager', jbatom());
    }

    public function testJbdata()
    {
        isClass('\JBZoo\Data\JSON', jbdata());

        $data  = jbdata();
        $data2 = jbdata($data);
        isSame($data, $data2);

        isSame('{"key":"value"}', json_encode(jbdata('{"key":"value"}')));
    }

    public function testJbt()
    {
        isSame('undefined_test_message', jbt('undefined_test_message'));
    }

    public function testJblog()
    {
        $variable = uniqid('variable-');
        $label    = uniqid('label-');

        jbLog($variable, $label);

        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';

        isFile($logFile);
        isContain($variable, file_get_contents($logFile));
        isContain($label, file_get_contents($logFile));
    }

    public function testDump()
    {
        $variable = uniqid('variable-');
        dump($variable, false, 'Dump function');
    }

    public function testJbd()
    {
        $variable = uniqid('variable-');
        jbd($variable, false, 'Dump function');
    }
}
