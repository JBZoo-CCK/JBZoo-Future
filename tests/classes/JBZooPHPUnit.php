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
use JBZoo\PimpleDumper\PimpleDumper;
use JBZoo\Utils\Url;

/**
 * Class CrossCMS
 * @package JBZoo\PHPUnit
 */
abstract class JBZooPHPUnit extends PHPUnit
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var UnitHelper
     */
    public $helper;

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
     * Setup before each test
     */
    protected function setUp()
    {
        parent::setUp();

        require_once PROJECT_ROOT . '/src/cck/init.php';

        $this->app    = App::getInstance();
        $this->helper = new UnitHelper();

        // Dump container for autocomplete
        if (!defined('JBZOO_PIMPLE_INIT')) {
            define('JBZOO_PIMPLE_INIT', true);

            $dumper = new PimpleDumper();
            $this->app->register($dumper);
        }
    }

    /**
     * Custom HTTP Request
     *
     * @param string $action
     * @param array  $query
     * @param string $path
     * @param bool   $isJson
     * @return Data
     */
    protected function _request($action, $query = [], $path = null, $isJson = false)
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
     * Custom HTTP Request for CMS Control panel
     *
     * @param string $action
     * @param array  $query
     * @param bool   $isJson
     * @return Data
     */
    protected function _requestAdmin($action, $query = [], $isJson = true)
    {
        $result = $this->_http(
            $this->_cmsParams['admin-path-' . __CMS__],
            $action,
            $query,
            [
                'Cookie' => $this->_getCookieForAdmin()
            ]
        );

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
        if ('joomla' === __CMS__) {
            return $this->_getCookieForJoomlaAdmin();
        } elseif ('wordpress' === __CMS__) {
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
                    '_cov'    => __CMS__ . '_' . $action,
                    'act'     => $action,
                    'nocache' => mt_rand(0, 100000)
                ],
                $query
            );
        }

        $result = $this->app['http']->request(
            Url::create([
                'host'  => PHPUNIT_HTTP_HOST,
                'user'  => PHPUNIT_HTTP_USER,
                'pass'  => PHPUNIT_HTTP_PASS,
                'path'  => $path ? $path : '/',
                'query' => $method == 'GET' ? $query : [],
            ]),

            ($method == 'POST') ? $query : [],

            [
                'response' => AbstractHttp::RESULT_FULL,
                'debug'    => 1,
                'headers'  => $headers,
                'method'   => $method,
            ]
        );

        return $result;
    }
}
