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

use JBZoo\Data\Data;
use JBZoo\Utils\Cli;
use JBZoo\Utils\Env;
use JBZoo\Utils\FS;
use JBZoo\Utils\Str;
use SuperClosure\Serializer;

/**
 * Class UnitHelper
 * @package JBZoo\PHPUnit
 */
class UnitHelper
{
    /**
     * @param \Closure $callback
     * @param array    $request
     * @return string
     * @throws \Exception
     */
    public function runIsolated(\Closure $callback, $request = array())
    {
        $binPaths = [
            './src/cck/vendor/jbzoo/console/bin/jbzoo',
            './vendor/jbzoo/console/bin/jbzoo'
        ];

        $binPath = null;
        foreach ($binPaths as $checkedPath) {
            if (file_exists($checkedPath)) {
                $binPath = $checkedPath;
            }
        }

        $testname = $this->_getTestName();
        $request  = new Data($request);

        $options = array(
            // test
            'test-func'      => $callback,
            'test-name'      => $testname,

            // phpunit
            'phpunit-test'   => FS::clean(PROJECT_ROOT . '/tests/unit/browser/BrowserEmulatorTest.php'),
            'phpunit-config' => FS::clean(PROJECT_ROOT . '/phpunit-browser.xml'),
            'phpunit-cov'    => FS::clean(PROJECT_ROOT . '/build/coverage_cov/' . $testname . '.cov'),

            // env
            'env-cms'        => $request->get('cms', __CMS__),
            'env-method'     => $request->get('method', 'GET'),
            'env-path'       => $request->get('path', '/'),
            'env-get'        => $this->_prepareQuery($request->get('get', [])),
            'env-post'       => $this->_prepareQuery($request->get('post', [])),
            'env-cookie'     => $this->_prepareQuery($request->get('cookie', [])),
        );

        $phpPath = Env::get('PHPUNIT_CMD_BIN', Env::VAR_STRING);
        $phpPath = $phpPath ?: 'php';

        $result = Cli::exec(
            $phpPath . ' ' . $binPath . ' cms',
            $this->_prepareOptions($options),
            PROJECT_ROOT,
            Env::get('PHPUNIT_CMD_VERB', Env::VAR_BOOL)
        );

        $savePath = PROJECT_ROOT . '/build/browser_html';
        @mkdir($savePath, 0777, true);
        file_put_contents($savePath . '/' . $testname . '.html', $result);

        return $result;
    }

    /**
     * @param $options
     * @return array
     */
    protected function _prepareOptions($options)
    {
        $result = [];
        foreach ($options as $key => $value) {
            if ('test-func' === $key) {
                $value = $this->_encodeTest($value);
            } else {
                $value = $this->_encode($value);
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @param string $testName
     * @return string
     */
    protected function _getTestName($testName = null)
    {
        if (null === $testName) {
            $objects = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
            foreach ($objects as $object) {
                if (isset($object['object']) && $object['object'] instanceof \PHPUnit_Framework_TestCase) {
                    $testName = $object['class'] . '_' . $object['function'];
                    break;
                }
            }
        }

        $testName = str_replace(__NAMESPACE__ . '\\', '', $testName);
        $testName = Str::splitCamelCase($testName, '_', true);
        $testName = preg_replace('/^test_/', '', $testName);
        $testName = preg_replace('/_test$/', '', $testName);
        $testName = str_replace('_test_test_', '_', $testName);

        $testName = __CMS__ . '_' . $testName;

        return $testName;
    }

    /**
     * @param mixed $data
     * @return string
     */
    protected function _encode($data)
    {
        return base64_encode(serialize($data));
    }

    /**
     * @param \Closure $test
     * @return string
     */
    protected function _encodeTest($test)
    {
        $serializer = new Serializer();
        $serialize  = $serializer->serialize($test);

        return $this->_encode($serialize);
    }

    /**
     * @param array $data
     * @return string
     */
    protected function _prepareQuery(array $data = array())
    {
        return (array)$data;
    }
}
