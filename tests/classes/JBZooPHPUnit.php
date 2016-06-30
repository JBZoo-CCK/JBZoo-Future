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
use JBZoo\Data\PHPArray;
use JBZoo\PimpleDumper\PimpleDumper;
use JBZoo\Utils\Env;
use JBZoo\Utils\Str;

/**
 * Class JBZooPHPUnitDatabase
 */
abstract class JBZooPHPUnit extends \PHPUnit_Extensions_Database_TestCase
{
    const DEFAULT_FIXTURE = 'default.php';

    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    protected $_fixtureFile = '';

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

        $this->helper = new UnitHelper();

        // Cleanup memory caches!
        $this->app['cfg']->cleanCache();
        $this->app['models']->cleanObjects();
        $this->app['types']->cleanObjects();

        // Dump container for autocomplete
        if (!defined('JBZOO_PIMPLE_INIT')) {
            define('JBZOO_PIMPLE_INIT', true);

            $dumper = new PimpleDumper();
            $this->app->register($dumper);
        }
    }

    /**
     * Init JBZoo Application
     */
    protected function _initJBZoo()
    {
        $this->app = App::getInstance();
    }

    /**
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    public function getConnection()
    {
        $this->_initJBZoo();

        $defaultDb = __CMS__ == 'joomla' ? 'ci_test_j' : 'ci_test_wp';

        $dbName = Env::get('DB_NAME', $defaultDb, Env::VAR_STRING);
        $dbHost = Env::get('DB_HOST', '127.0.0.1', Env::VAR_STRING);
        $dbUser = Env::get('DB_USER', 'root', Env::VAR_STRING);
        $dbPass = Env::get('DB_PASS', '', Env::VAR_STRING);

        $dsn = "mysql:host={$dbHost};dbname={$dbName}";
        $pdo = new \PDO($dsn, $dbUser, $dbPass);

        $connection = $this->createDefaultDBConnection($pdo, $dbName);

        return $connection;
    }

    /**
     * @return DataSet
     * @throws \Exception
     */
    public function getDataSet()
    {
        $this->_fixtureFile = $this->_fixtureFile ?: Str::getClassName($this) . '.php';

        $fixturePath = PROJECT_FIXTURES . '/' . $this->_fixtureFile;
        if (!file_exists($fixturePath)) {
            $fixturePath = PROJECT_FIXTURES . '/' . self::DEFAULT_FIXTURE;
        }

        if (file_exists($fixturePath)) {
            $data = new PHPArray($fixturePath);
            return new DataSet((array)$data);
        } else {
            throw new \Exception("Fixture file {$fixturePath} is not found!");
        }
    }
}
