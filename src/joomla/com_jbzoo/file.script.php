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
        $this->_buildTables();
    }

    /**
     * Uninstall action
     */
    public function uninstall()
    {
        //$this->installer->uninstall();

        $db = JFactory::getDbo();
        $db->setQuery("DROP TABLE IF EXISTS `#__jbzoo_config`;")->execute();
        $db->setQuery("DROP TABLE IF EXISTS `#__jbzoo_modules`;")->execute();
        $db->setQuery("DROP TABLE IF EXISTS `#__jbzoo_items`;")->execute();
    }

    /**
     * Install action
     */
    public function update()
    {
        //$this->installer->update();

        $this->install();
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

    /**
     * Build jbzoo tables.
     * @return void
     */
    protected function _buildTables()
    {
        $db = JFactory::getDbo();

        // Create modules table
        $db->setQuery(
            "CREATE TABLE IF NOT EXISTS `#__jbzoo_modules` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                      `title` varchar(80) DEFAULT NULL,
                      `params` text,
                      PRIMARY KEY (`id`)
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB;"
        )->execute();

        // Create config table
        $db->setQuery(
            "CREATE TABLE IF NOT EXISTS `#__jbzoo_config` (
                    `option` VARCHAR(250) NOT NULL DEFAULT '',
                    `value` LONGTEXT NOT NULL,
                    `autoload` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
                    UNIQUE INDEX `option_name` (`option`),
                    INDEX `autoload` (`autoload`)
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB;"
        )->execute();

        // Create items table
        $db->setQuery(
            "CREATE TABLE `#__jbzoo_items` (
            	`id` INT(11) NOT NULL AUTO_INCREMENT,
            	`type` VARCHAR(255) NOT NULL,
            	`name` VARCHAR(255) NOT NULL,
            	`alias` VARCHAR(255) NOT NULL,
            	`created` DATETIME NOT NULL,
            	`created_by` INT(11) NOT NULL,
            	`modified` DATETIME NOT NULL,
            	`publish_up` DATETIME NOT NULL,
            	`publish_down` DATETIME NOT NULL,
            	`state` TINYINT(3) NOT NULL,
            	`elements` LONGTEXT NOT NULL,
            	`params` LONGTEXT NOT NULL,
            	PRIMARY KEY (`id`),
            	UNIQUE INDEX `ALIAS_INDEX` (`alias`),
            	INDEX `PUBLISH_INDEX` (`publish_up`, `publish_down`),
            	INDEX `STATE_INDEX` (`state`),
            	INDEX `CREATED_BY_INDEX` (`created_by`),
            	INDEX `NAME_INDEX` (`name`),
            	INDEX `TYPE_INDEX` (`type`),
            	INDEX `MULTI_INDEX` (`state`, `publish_up`, `publish_down`),
            	INDEX `MULTI_INDEX2` (`id`, `state`, `publish_up`, `publish_down`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;"
        )->execute();
    }
}
