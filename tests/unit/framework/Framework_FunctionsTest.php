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

use JBZoo\CCK\Atom\Core\Helper\Debug;
use JBZoo\SqlBuilder\Query\Select;
use JBZoo\Utils\FS;
use JBZoo\Utils\Sys;

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
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_JBDUMP,
            'ip'     => Sys::IP(),
            'log'    => 1,
        ]], true);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');

        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';
        @unlink($logFile);


        // Test it!!!
        isTrue(jbLog($variable, $label));

        isFile($logFile);
        isContain($variable, file_get_contents($logFile));
        isContain($label, file_get_contents($logFile));
    }

    public function testJblogArray()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_JBDUMP,
            'ip'     => Sys::IP(),
            'log'    => 1,
        ]], true);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');

        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';
        @unlink($logFile);


        // Test it!!!
        isTrue(jbd()->logArray($variable, $label));


        isFile($logFile);
        isContain($variable, file_get_contents($logFile));
        isContain($label, file_get_contents($logFile));
    }

    public function testJBD_ModeNone()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_NONE,
            'ip'     => Sys::IP(),
        ]], false);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');


        // Test it!!!
        ob_start();
        isTrue(jbd($variable, false, $label));
        $info = ob_get_clean();

        isEmpty($info);
    }

    public function testJBD_ModeVarDump()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_VAR_DUMP,
            'ip'     => Sys::IP(),
        ]], false);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');


        // Test it!!!
        ob_start();
        isTrue(jbd($variable, false, $label));
        $info = ob_get_clean();

        isContain($variable, $info);
        isContain($label, $info);
    }

    public function testJBD_Alias()
    {
        isTrue(function_exists('dump'));

        $func = new \ReflectionFunction('dump');

        $joomlaPath = FS::clean('/src/joomla');
        $wpPath     = FS::clean('/src/wordpress');

        if (strpos($func->getFileName(), $joomlaPath) !== false
            || strpos($func->getFileName(), $wpPath) !== false
        ) {
            isSame(jbd(), dump());
        }
    }

    public function testJBD_ModeJBDump()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_JBDUMP,
            'ip'     => Sys::IP(),
        ]], false);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');


        // Test it!!!
        ob_start();
        isTrue(jbd($variable, false, $label));
        $info = ob_get_clean();


        isContain($variable, $info);
        isContain($label, $info);
    }

    public function testJBD_RescrictIP()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_SYMFONY,
            'ip'     => Sys::IP() . '.666', // invalid IP
        ]], false);
        $this->app['dbg']->reInitConfig();

        $variable = uniqid('variable-');
        $label    = uniqid('label-');

        // Test it!!!
        ob_start();
        isFalse(jbd($variable, false, $label));
        $info = ob_get_clean();

        isEmpty($info);
    }

    public function testJBD_EmptyIpList()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_SYMFONY,
        ]], false);
        $this->app['dbg']->reInitConfig();

        // Test it!!!
        isFalse(jbd('qwerty'));
    }

    public function testJBD_SqlJBDump()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_JBDUMP,
            'ip'     => Sys::IP(),
            'sql'    => 1,
        ]], false);
        $this->app['dbg']->reInitConfig();


        // Test it!!!
        ob_start();
        $selectSql = new Select('table');
        isTrue(jbd()->sql($selectSql));
        $info = ob_get_clean();


        isContain('SELECT', $info);
    }

    public function testJBD_SqlVarDump()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_VAR_DUMP,
            'ip'     => Sys::IP(),
            'sql'    => 1,
        ]], false);
        $this->app['dbg']->reInitConfig();


        // Test it!!!
        ob_start();
        $selectSql = new Select('table');
        isTrue(jbd()->sql($selectSql));
        $info = ob_get_clean();


        isContain('SELECT', $info);
    }

    public function testJBD_Trace()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_VAR_DUMP,
            'ip'     => Sys::IP(),
            'trace'  => 1,
        ]], false);
        $this->app['dbg']->reInitConfig();

        // Test it!!!
        ob_start();
        isTrue(jbd()->trace(false));
        $info = ob_get_clean();


        isContain(__FUNCTION__, $info);
    }

    public function testJBD_TraceToLog()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper' => Debug::MODE_VAR_DUMP,
            'ip'     => Sys::IP(),
            'trace'  => 1,
            'log'    => 1,
        ]], false);
        $this->app['dbg']->reInitConfig();

        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';
        @unlink($logFile);

        // Test it!!!
        isTrue(jbd()->trace(true));

        isFile($logFile);
        isContain(__FUNCTION__, file_get_contents($logFile));
    }

    public function testJBD_Profiler()
    {
        $this->app['cfg']->set('atom.core', ['debug' => [
            'dumper'   => Debug::MODE_VAR_DUMP,
            'ip'       => Sys::IP(),
            'profiler' => 1,
        ]], false);
        $this->app['dbg']->reInitConfig();


        $logFile = PROJECT_ROOT . '/logs/jbdump_' . date('Y.m.d') . '.log.php';
        @unlink($logFile);


        // Test it!!!
        isTrue(jbd()->mark());
    }
}
