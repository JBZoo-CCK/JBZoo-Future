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

/**
 * Class pkg_jbzooInstallerScript
 */
class pkg_jbzooInstallerScript
{
    /**
     * Install action
     */
    public function install()
    {
        echo __METHOD__ . PHP_EOL . PHP_EOL;
    }

    /**
     * Uninstall action
     */
    public function uninstall()
    {
        echo __METHOD__ . PHP_EOL . PHP_EOL;
    }

    /**
     * Install action
     */
    public function update()
    {
        echo __METHOD__ . PHP_EOL . PHP_EOL;
    }

    /**
     * Preflight action
     */
    public function preflight()
    {
        echo __METHOD__ . PHP_EOL . PHP_EOL;
    }

    /**
     * Postflight action
     */
    public function postflight()
    {
        echo __METHOD__ . PHP_EOL . PHP_EOL;

        self::_enablePlugin('jbzoocck');
    }

    /**
     * Enable plugin by name
     * @param $plugin
     */
    private static function _enablePlugin($plugin)
    {
        $db = JFactory::getDbo();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "' . $plugin . '"');
        $db->execute();
    }
}
