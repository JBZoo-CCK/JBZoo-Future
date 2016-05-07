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
 */
class Installer extends Helper
{
    /**
     * Script to install component
     */
    public function install()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `#__jbzoo_config` (
            `option` VARCHAR(250) NOT NULL DEFAULT '',
            `value` LONGTEXT NOT NULL,
            `autoload` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
            UNIQUE INDEX `option_name` (`option`),
            INDEX `autoload` (`autoload`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;";

        if ($this->app['db']->query($sql) === false) {
            throw new \RuntimeException('Unable to create JBZoo tables.');
        }
    }

    /**
     * Script to uninstall component
     */
    public function uninstall()
    {
        $sql = "DROP TABLE IF EXISTS `#__jbzoo_config`";

        if ($this->app['db']->query($sql) === false) {
            throw new \RuntimeException('Unable to remove JBZoo tables.');
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
