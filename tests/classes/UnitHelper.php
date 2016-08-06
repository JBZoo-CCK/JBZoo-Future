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

use JBZoo\CCK\App;
use JBZoo\CrossCMS\AbstractHttp;
use JBZoo\Data\Data;
use JBZoo\HttpClient\Response;
use JBZoo\Utils\Cli;
use JBZoo\Utils\Env;
use JBZoo\Utils\FS;
use JBZoo\Utils\Str;
use JBZoo\Utils\Url;

/**
 * Class UnitHelper
 * @package JBZoo\PHPUnit
 */
class UnitHelper
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var array
     */
    protected $_cmsParams = [
        'admin-login-joomla'  => '/administrator/index.php',
        'admin-path-joomla'   => '/administrator/index.php',
        'admin-params-joomla' => [
            'option' => 'com_jbzoo',
        ],

        'admin-login-wordpress'  => '/wp-login.php',
        'admin-path-wordpress'   => '/wp-admin/admin.php',
        'admin-params-wordpress' => [
            'page' => 'jbzoo',
        ],

        'site-path-joomla'      => '/index.php',
        'site-path-wordpress'   => '/',
        'site-params-joomla'    => [
            'option' => 'com_jbzoo',
        ],
        'site-params-wordpress' => [
            'page' => 'jbzoo',
            'p'    => WP_POST_ID,
        ]
    ];

    /**
     * UnitHelper constructor.
     */
    public function __construct()
    {
        $this->app = App::getInstance();
    }

    /**
     * @param \Closure $callback
     * @param array    $request
     * @return string
     * @throws \Exception
     */
    public function runIsolated(\Closure $callback, $request = array())
    {
        $binPaths = [
            './src/cck/libraries/jbzoo/console/bin/jbzoo',
            './vendor/jbzoo/console/bin/jbzoo'
        ];

        $binPath = null;
        foreach ($binPaths as $checkedPath) {
            if (file_exists($checkedPath)) {
                $binPath = $checkedPath;
            }
        }

        $testname = $this->_getTestName();
        dump($testname);
        die(1);

        $request  = new Data($request);

        $options = array(
            // test
            'test-func'      => $callback,
            'test-name'      => $testname,

            // phpunit
            'phpunit-test'   => FS::clean(PROJECT_ROOT . '/tests/unit/browser/Browser_EmulatorTest.php'),
            'phpunit-config' => FS::clean(PROJECT_ROOT . '/phpunit-browser.xml'),
            'phpunit-cov'    => FS::clean(PROJECT_ROOT . '/build/coverage_cov/' . $testname . '.cov'),

            // env
            'env-cms'        => $request->get('cms', __CMS__),
            'env-method'     => $request->get('method', 'GET'),
            'env-path'       => $request->get('path', '/index.php'),
            'env-get'        => $this->_prepareQuery($request->get('get', [])),
            'env-post'       => $this->_prepareQuery($request->get('post', [])),
            'env-cookie'     => $this->_prepareQuery($request->get('cookie', [])),
        );

        $phpPath = Env::get('PHPUNIT_CMD_BIN', 'php', Env::VAR_STRING);

        $result = Cli::exec(
            $phpPath . ' ' . $binPath . ' cms',
            $this->_prepareOptions($options),
            PROJECT_ROOT,
            Env::get('PHPUNIT_CMD_VERB', 0, Env::VAR_BOOL)
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

    /**
     * Custom HTTP Request
     *
     * @param string $action
     * @param array  $query
     * @param string $path
     * @param bool   $isJson
     * @return Response
     */
    public function request($action, $query = [], $path = null, $isJson = false)
    {
        $result = $this->_http(
            $path ? $path : $this->_cmsParams['site-path-' . __CMS__],
            $action,
            $query
        );

        if ($isJson && strpos($result->find('headers.content-type'), 'application/json') !== false) {
            return jbdata($result->get('body', '{}'));
        }

        return $result;
    }

    /**
     * Experimental!
     *
     * @param array $requests
     * @return array
     */
    public function requestAdminBatch(array $requests)
    {
        $cookie = $this->_getCookieForAdmin();

        $result = [];
        foreach ($requests as $request) {
            $request  = jbdata($request);
            $result[] = $this->requestAdmin(
                $request->get('0'),
                $request->get('1', []),
                $request->get('2', 'POST'),
                $request->get('3', true),
                $cookie
            );
        }

        return $result;
    }

    /**
     * Custom HTTP Request for CMS Control panel
     *
     * @param string $action
     * @param array  $query
     * @param string $method
     * @param bool   $isJson
     * @param string $customCookie
     * @return Data
     */
    public function requestAdmin($action, $query = [], $method = 'POST', $isJson = true, $customCookie = '')
    {
        if ($method !== 'PAYLOAD') {
            $result = $this->_http(
                $this->_cmsParams['admin-path-' . __CMS__],
                $action,
                $query,
                [
                    'Cookie' => $customCookie ? $customCookie : $this->_getCookieForAdmin()
                ],
                $method
            );

        } else {
            $result = $this->app['http']->request(
                Url::create([
                    'host'  => PHPUNIT_HTTP_HOST,
                    'user'  => PHPUNIT_HTTP_USER,
                    'pass'  => PHPUNIT_HTTP_PASS,
                    'path'  => $this->_cmsParams['admin-path-' . __CMS__],
                    'query' => Url::build([
                        'option' => 'com_jbzoo',
                        'act'    => $action,
                    ])
                ]),
                json_encode($query),
                [
                    'method'   => 'POST',
                    'response' => AbstractHttp::RESULT_FULL,
                    'debug'    => 1,
                    'headers'  => [
                        'Cookie'       => $customCookie ? $customCookie : $this->_getCookieForAdmin(),
                        'Content-Type' => 'application/json'
                    ],
                ]
            );
        }

        if ($isJson && strpos($result->find('headers.content-type'), 'application/json') !== false) {
            return jbdata($result->get('body', '{}'));
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function _getCookieForAdmin()
    {
        if (__CMS__ === JOOMLA) {
            return $this->_getCookieForJoomlaAdmin();
        } elseif (__CMS__ === WORDPRESS) {
            skip("Wordpress doesn't support request to CP");
            return $this->_getCookieForWordpressAdmin();
        }
    }

    /**
     * @return string
     */
    protected function _getCookieForJoomlaAdmin()
    {
        // Get Token and Cookie hashes
        $result = $this->_http(
            $this->_cmsParams['admin-login-' . __CMS__]
        );

        // Parse response
        list($cookie) = explode(';', $result->find('headers.set-cookie'), 2);
        preg_match('#<input type="hidden" name="(.{32})" value="1" />\t#ius', $result->body, $matches);
        $token = $matches[1];

        $this->_http(
            $this->_cmsParams['admin-path-' . __CMS__],
            '',
            [
                'username' => 'admin',
                'passwd'   => 'admin',
                'option'   => 'com_login',
                'task'     => 'login',
                'return'   => 'aW5kZXgucGhw',
                $token     => 1
            ],
            [
                'Cookie' => $cookie
            ],
            'POST'
        );

        return $cookie;
    }

    /**
     * @return string
     */
    protected function _getCookieForWordpressAdmin()
    {
        // Get Token and Cookie hashes
        $result = $this->_http($this->_cmsParams['admin-login-' . __CMS__], null, null);

        // Parse response
        list($cookie) = explode(';', $result->find('headers.set-cookie'), 2);

        $result = $this->_http(
            $this->_cmsParams['admin-login-' . __CMS__],
            null,
            [
                'log'         => 'admin',
                'pwd'         => 'admin',
                'wp-submit'   => 'Log In',
                'redirect_to' => Url::create([
                    'host' => PHPUNIT_HTTP_HOST,
                    'user' => PHPUNIT_HTTP_USER,
                    'pass' => PHPUNIT_HTTP_PASS,
                    'path' => '/wp-admin/',
                ]),
                'testcookie'  => '1'
            ],
            [
                'Cookie' => $cookie
            ],
            'POST'
        );

        // Parse response
        list($cookie) = explode(';', $result->find('headers.set-cookie.0'), 2);

        return $cookie;
    }

    /**
     * @param string $path
     * @param string $action
     * @param array  $query
     * @param array  $headers
     * @param string $method
     * @return mixed|null
     */
    protected function _http($path, $action = '', $query = [], $headers = [], $method = 'GET')
    {
        if (null === $query) {
            $query = [];
        } else {
            $query = array_merge(
                $this->_cmsParams['site-params-' . __CMS__],
                [
                    'act'     => $action,
                    'nocache' => mt_rand(0, 100000)
                ],
                $query
            );
        }

        $url = Url::create([
            'host' => PHPUNIT_HTTP_HOST,
            'user' => PHPUNIT_HTTP_USER,
            'pass' => PHPUNIT_HTTP_PASS,
            'path' => $path ? $path : '/',
        ]);

        $result = httpRequest(
            $url,
            $query,
            $method,
            [
                'headers'         => $headers,
                'timeout'         => 10,
                'verify'          => false,
                'exceptions'      => false,
                'allow_redirects' => true,
            ]
        );

        return $result;
    }
}
