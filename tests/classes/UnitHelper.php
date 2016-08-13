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
use JBZoo\Data\JSON;
use JBZoo\HttpClient\Response;
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
     * Custom HTTP Request
     *
     * @param string $action
     * @param array  $query
     * @param string $path
     * @param bool   $isJson
     * @return Response|JSON
     * @throws Exception
     */
    public function request($action, $query = [], $path = null, $isJson = false)
    {
        $result = $this->_http(
            $path ? $path : $this->_cmsParams['site-path-' . __CMS__],
            $action,
            $query
        );

        if ($isJson) {

            if (strpos($result->getHeader('content-type'), 'application/json') !== false) {
                return $result->getJSON();
            } else {
                dump(func_get_args(), 0);
                dump($result);
                throw new Exception('Invalid header: not application/json');
            }
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
     * @return Response|JSON
     * @throws Exception
     */
    public function requestAdmin($action, $query = [], $method = 'POST', $isJson = true, $customCookie = '')
    {
        $result = $this->_http(
            $this->_cmsParams['admin-path-' . __CMS__],
            $action,
            $query,
            [
                'Cookie' => $customCookie ? $customCookie : $this->_getCookieForAdmin()
            ],
            $method
        );

        if ($isJson && strpos($result->getHeader('content-type'), 'application/json') !== false) {
            if (strpos($result->getHeader('content-type'), 'application/json') !== false) {
                return $result->getJSON();
            } else {
                dump(func_get_args(), 0);
                dump($result);
                throw new Exception('Invalid header: not application/json');
            }
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
     * @param string       $path
     * @param string       $action
     * @param array|string $query
     * @param array        $headers
     * @param string       $method
     * @return Response
     */
    protected function _http($path, $action = '', $query = [], $headers = [], $method = 'GET')
    {
        $urlParams = [
            'host'  => PHPUNIT_HTTP_HOST,
            'user'  => PHPUNIT_HTTP_USER,
            'pass'  => PHPUNIT_HTTP_PASS,
            'path'  => $path ? $path : '/',
            'query' => [],
        ];

        $method = strtoupper($method);

        if ('PAYLOAD' === $method) {
            $method = 'POST';
            $query  = json_encode($query);

            $urlParams['query'] = array_merge(
                $this->_cmsParams['site-params-' . __CMS__],
                [
                    'act'     => $action,
                    'nocache' => mt_rand(0, 100000)
                ]
            );

            $headers['Content-Type'] = 'application/json';

        } else {
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

            $urlParams['query'] = $query;
        }

        $urlParams['query'] = array_filter($urlParams['query']);

        $url    = Url::create($urlParams);
        $result = $this->_httpRequest($url, $query, $method, $headers);

        return $result;
    }

    /**
     * @param string       $url
     * @param string|array $query
     * @param string       $method
     * @param array        $headers
     * @return Response
     */
    protected function _httpRequest($url, $query, $method, $headers)
    {
        $result = httpRequest($url, $query, $method, [
            'headers'         => $headers,
            'timeout'         => 30,
            'verify'          => false,
            'exceptions'      => false,
            'allow_redirects' => true,
        ]);

        $body = $result->getBody();
        $body = preg_replace('#\<script\>.*?\<\/script\>#ius', ' ', $body);
        $body = preg_replace('#\<style\>.*?\<\/style\>#ius', ' ', $body);
        $body = strip_tags($body);
        $body = preg_replace('#\s{2,}#', ' ', $body);
        $body = trim($body);

        dump([
            'request'  => [
                'url'     => $url,
                'query'   => $query,
                'method'  => $method,
                'headers' => $headers
            ],
            'response' => [
                'code' => $result->getCode(),
                'type' => $result->getHeader('content-type'),
                'body' => Str::sub($body, 0, 1000),
            ]
        ], 0, $this->_getTestName());

        return $result;
    }

    /**
     * @return null|string
     */
    protected function _getTestName()
    {
        $objects = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);

        foreach ($objects as $object) {
            if (isset($object['object']) && $object['object'] instanceof \PHPUnit_Framework_TestCase) {
                return get_class($object['object']) . '::' . $object['function'];
            }
        }

        return null;
    }
}
