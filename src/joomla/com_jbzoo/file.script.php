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

        $db = JFactory::getDbo();
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

        $db->setQuery(
                "CREATE TABLE IF NOT EXISTS `#__jbzoo_modules` (
                      `id` int(11) NOT NULL,
                      `title` varchar(80) DEFAULT NULL,
                      `params` text
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB;"
            )
            ->setQuery(
                "ALTER TABLE `#__jbzoo_modules` ADD PRIMARY KEY (`id`);"
            )
            ->setQuery(
                "ALTER TABLE `#__jbzoo_modules` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
            )
            ->execute();
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
            require_once $file;

        } elseif ($file = realpath(JPATH_ADMINISTRATOR . '/components/com_jbzoo/cck/init.php')) {
            require_once $file;
        }

        $this->app       = App::getInstance();
        $this->installer = $this->app['atoms']['core']['installer'];
    }
}
