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
     * @param string $path
     * @param array  $query
     * @return Data
     */
    protected function _request($action, $path = '/', $query = [])
    {
        $url = Url::create([
            'host'  => PHPUNIT_HTTP_HOST,
            'user'  => PHPUNIT_HTTP_USER,
            'pass'  => PHPUNIT_HTTP_PASS,
            'path'  => $path,
            'query' => array_merge([
                'option'  => 'com_jbzoo',
                'page'    => 'jbzoo',
                'p'       => WP_POST_ID,
                'act'     => $action,
                'nocache' => rand(0, 100000)
            ], $query)
        ]);

        $result = $this->app['http']->request($url, [], [
            'response'  => AbstractHttp::RESULT_FULL,
            'cache'     => 0,
            'cache_ttl' => 0,
            'debug'     => 1
        ]);

        return $result;
    }

}
