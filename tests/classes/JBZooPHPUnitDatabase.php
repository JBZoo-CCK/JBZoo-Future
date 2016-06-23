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
use JBZoo\Utils\Env;

/**
 * Class JBZooPHPUnitDatabase
 */
abstract class JBZooPHPUnitDatabase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var string
     */
    protected $_fixtureFile = '';

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

        $dsn = 'mysql:host=' . $dbHost . ';dbname=' . $dbName;
        $pdo = new \PDO($dsn, $dbUser, $dbPass);

        return $this->createDefaultDBConnection($pdo, $dbName);
    }

    /**
     * @return DataSet
     * @throws \Exception
     */
    public function getDataSet()
    {
        if ($this->_fixtureFile) {
            $data = new PHPArray(PROJECT_FIXTURES . '/' . $this->_fixtureFile);
            return new DataSet((array)$data);
        } else {
            throw new \Exception('$this->_fixtureFile is not set!');
        }
    }

    protected function _initJBZoo()
    {
        $this->app = App::getInstance();
    }
}
