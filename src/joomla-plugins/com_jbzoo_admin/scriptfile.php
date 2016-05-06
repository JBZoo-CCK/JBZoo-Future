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

echo ('scriptfile.php!!');
die(100);

/**
 * Class com_jbzooInstallerScript
 */
class com_jbzooInstallerScript
{
    /**
     * Init JBZoo framework
     */
    protected function _loadJBZoo()
    {
        if ($initFile = realpath(__DIR__ . '/jbzoo/init.php')) {
            require_once $initFile;
        }
    }

    /**
     * Run install script
     */
    public function install()
    {
        $this->_loadJBZoo();

        $app = App::getInstance();
        die('11111111');
        $app['atoms']['core']['installer']->install();
    }

    /**
     * Run uninstall script
     */
    public function uninstall()
    {
        $this->_loadJBZoo();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->uninstall();
    }

    /**
     * Run update script
     */
    public function update()
    {
        $this->_loadJBZoo();

        $app = App::getInstance();
        $app['atoms']['core']['installer']->update();
    }
}
