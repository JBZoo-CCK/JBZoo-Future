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

use JBZoo\Data\JSON;
use JBZoo\Utils\Cli;
use JBZoo\Utils\FS;
use SuperClosure\Serializer;

/**
 * Class UnitHelper
 * @package JBZoo\PHPUnit
 */
class UnitHelper
{
    /**
     * @param string   $testname
     * @param \Closure $callback
     * @param array    $request
     * @param string   $path
     * @param string   $method
     * @return string
     * @throws \Exception
     */
    public function runIsolated($testname, \Closure $callback, $request = array(), $path = '/', $method = 'GET')
    {
        $composerConfig = new JSON(PROJECT_ROOT . '/composer.json');
        $vendorDir      = $composerConfig->find('config.vendor-dir', 'vendor');
        $binPath        = './' . $vendorDir . '/jbzoo/console/bin/jbzoo';

        $testname = __CMS__ . '_' . $testname;

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
            'env-cms'        => __CMS__,
            'env-method'     => strtoupper($method),
            'env-path'       => $path,
            'env-request'    => $this->_prepareQuery($request),
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
    protected function _getTestName($testName)
    {
        $testName = str_replace(__NAMESPACE__, '', $testName);
        $testName = preg_replace('#[^a-z0-9]#iu', '-', $testName);
        $testName = preg_replace('#--#iu', '-', $testName);
        $testName = trim($testName, '-');
        $testName = strtolower($testName);

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
        $data = (array)$data;

        $data['jbzoo-phpunit'] = 1;

        return $data;
    }
}