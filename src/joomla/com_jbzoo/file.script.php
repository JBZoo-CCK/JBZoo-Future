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

use JBZoo\CCK\App;
use JBZoo\CCK\Atom\Core\Helper\Installer;

/**
 * Class com_jbzooInstallerScript
 * @codeCoverageIgnore
 */
class com_jbzooInstallerScript
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var Installer
     */
    public $installer;

    /**
     * JBZoo Installer Script constructor.
     */
    public function __construct()
    {
        // $this->_init();
    }

    /**
     * Install action
     */
    public function install()
    {
        //$this->installer->install();

        $database = JFactory::getDbo();
        $queries  = $this->_getQueries('install.sql');
        foreach ($queries as $query) {
            $database->setQuery($query)->execute();
        }
    }

    /**
     * Uninstall action
     */
    public function uninstall()
    {
        //$this->installer->uninstall();

        $database = JFactory::getDbo();
        $queries  = $this->_getQueries('unstall.sql');
        foreach ($queries as $query) {
            $database->setQuery($query)->execute();
        }
    }

    /**
     * Open and split SQL file
     *
     * @param $filename
     * @return array
     * @throws Exception
     */
    protected function _getQueries($filename)
    {
        $path = __DIR__ . '/admin/cck/install/' . $filename;
        if (file_exists($path)) {
            $queries = file_get_contents($path);
            $queries = JFactory::getDbo()->splitSql($queries);

            return (array)$queries;
        }

        throw new Exception("SQL file {$path} not found!");
    }

    /**
     * Install action
     */
    public function update()
    {
        //$this->installer->update();
    }

    /**
     * Preflight action
     */
    public function preflight()
    {
        //$this->installer->preflight();
    }

    /**
     * Postflight action
     */
    public function postflight()
    {
        //$this->installer->postflight();
    }

    /**
     * Init JBZoo framework
     * @return mixed
     */
    protected function _init()
    {
        if ($file = realpath(__DIR__ . '/admin/cck/init.php')) {
            /** @noinspection PhpIncludeInspection */
            require_once $file;

        } elseif ($file = realpath(JPATH_ADMINISTRATOR . '/components/com_jbzoo/cck/init.php')) {
            /** @noinspection PhpIncludeInspection */
            require_once $file;
        }

        $this->app       = App::getInstance();
        $this->installer = $this->app['atoms']['core']['installer'];
    }
}
