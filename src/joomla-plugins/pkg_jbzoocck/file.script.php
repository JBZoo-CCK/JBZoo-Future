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
 * Class pkg_jbzoocckInstallerScript
 */
class pkg_jbzoocckInstallerScript
{
    /**
     * Install action
     */
    public function install()
    {
    }

    /**
     * Uninstall action
     */
    public function uninstall()
    {
    }

    /**
     * Install action
     */
    public function update()
    {
    }

    /**
     * Preflight action
     */
    public function preflight()
    {
    }

    /**
     * Postflight action
     */
    public function postflight()
    {
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
