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

use JBZoo\Data\Data;
use JBZoo\Data\JSON;
use JBZoo\Utils\Cli;
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
        $composerConfig = new JSON(PROJECT_ROOT . '/composer.json');
        $vendorDir      = $composerConfig->find('config.vendor-dir', 'vendor');
        $binPath        = './' . $vendorDir . '/jbzoo/console/bin/jbzoo';

        $testname = $this->_getTestName();
        $request  = new Data($request);

        $options = array(
            // test
            'test-func'      => $callback,
            'test-name'      => $testname,

            // phpunit
            'phpunit-test'   => FS::clean(PROJECT_ROOT . '/tests/unit-browser/BrowserEmulatorTest.php'),
            'phpunit-config' => FS::clean(PROJECT_ROOT . '/phpunit-browser.xml'),
            'phpunit-clover' => FS::clean(PROJECT_ROOT . '/build/clover-xml/' . $testname . '.xml'),
            'phpunit-html'   => FS::clean(PROJECT_ROOT . '/build/clover-html/' . $testname),

            // env
            'env-cms'        => $request->get('cms', __CMS__),
            'env-method'     => $request->get('method', 'GET'),
            'env-path'       => $request->get('path', '/'),
            'env-get'        => $this->_prepareQuery($request->get('get', [])),
            'env-post'       => $this->_prepareQuery($request->get('post', [])),
            'env-cookie'     => $this->_prepareQuery($request->get('cookie', [])),
        );

        $result = Cli::exec('php ' . $binPath . ' cms', $this->_prepareOptions($options), PROJECT_ROOT, 0);

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