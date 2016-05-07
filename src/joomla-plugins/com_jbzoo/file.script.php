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

/**
 * Class com_jbzooInstallerScript
 */
class com_jbzooInstallerScript
{
    /**
     * Install action
     */
    public function install()
    {
        $this->_init();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->install();
    }

    /**
     * Uninstall action
     */
    public function uninstall()
    {
        $this->_init();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->uninstall();
    }

    /**
     * Install action
     */
    public function update()
    {
        $this->_init();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->update();
    }

    /**
     * Preflight action
     */
    public function preflight()
    {
        $this->_init();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->preflight();
    }

    /**
     * Postflight action
     */
    public function postflight()
    {
        $this->_init();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->postflight();
    }

    /**
     * Init JBZoo framework
     * @return mixed
     */
    protected function _init()
    {
        return require_once JPATH_ADMINISTRATOR . '/components/com_jbzoo/cck/init.php';
    }
}
