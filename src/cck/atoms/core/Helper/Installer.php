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

namespace JBZoo\CCK\Atom\Core\Helper;

use JBZoo\CCK\Atom\Helper;

/**
 * Class Debug
 * @package JBZoo\CCK
 * @codeCoverageIgnore
 */
class Installer extends Helper
{
    /**
     * Script to install component
     */
    public function install()
    {
        $sql   = [];
        $sql[] = "CREATE TABLE IF NOT EXISTS `#__jbzoo_config` (
            `option` VARCHAR(250) NOT NULL DEFAULT '',
            `value` LONGTEXT NOT NULL,
            `autoload` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
            UNIQUE INDEX `option_name` (`option`),
            INDEX `autoload` (`autoload`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;";

        $sql[] = "CREATE TABLE IF NOT EXISTS `#__jbzoo_modules` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(80) DEFAULT NULL,
              `params` text,
              PRIMARY KEY (`id`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;";

        $sql[] = "CREATE TABLE `#__jbzoo_items` (
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
        ENGINE=InnoDB;";

        foreach ($sql as $query) {
            if ($this->app['db']->query($query) === false) {
                throw new \RuntimeException('Unable to create JBZoo tables.');
            }
        }
    }

    /**
     * Script to uninstall component
     */
    public function uninstall()
    {
        $sql   = [];
        $sql[] = "DROP TABLE IF EXISTS `#__jbzoo_config`;";
        $sql[] = "DROP TABLE IF EXISTS `#__jbzoo_modules`;";
        $sql[] = "DROP TABLE IF EXISTS `#__jbzoo_items`;";

        foreach ($sql as $query) {
            if ($this->app['db']->query($query) === false) {
                throw new \RuntimeException('Unable to remove JBZoo tables.');
            }
        }
    }

    /**
     * Script to update component
     */
    public function update()
    {

    }

    /**
     * Script before install component
     */
    public function preflight()
    {

    }

    /**
     * Script after install component
     */
    public function postflight()
    {

    }
}
