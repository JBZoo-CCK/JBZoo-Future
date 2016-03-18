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

/**
 * Class ApplicationTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class ApplicationTest extends JBZooPHPUnit
{
    public function testInstance()
    {
        isClass('\JBZoo\CCK\App', App::getInstance());
        isClass('\JBZoo\CCK\App', $this->app);
        isClass('\JBZoo\CCK\App', jbApp());

        isSame(App::getInstance(), jbApp());
        isSame($this->app, jbApp());
        isSame($this->app, App::getInstance());

        isNotSame($this->app, new App());
    }

    public function testAtomManager()
    {
        isClass('\JBZoo\CCK\Atom\Manager', $this->app['atoms']);
    }

    public function testAtom()
    {
        isClass('\JBZoo\CCK\Atom\Core\Core', $this->app['atoms']['core']);
        isClass('\JBZoo\CCK\Atom\Core\Core', jbAtom('core'));

        isSame(jbAtom('core'), $this->app['atoms']['core']);
    }

    public function testAliasFunction()
    {
        isClass('\JBZoo\CCK\App', jbApp());
        isClass('\Composer\Autoload\ClassLoader', jbApp('loader'));
    }

    public function testNotInitTwice()
    {
        isSame(false, jbApp()->init());
    }

    /**
     * @expectedException \Error
     */
    public function testGetUndefinedHelper()
    {
        skip('Wordpress crash');
        jbApp('undefined');
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testGetUndefinedAtomHelper()
    {
        jbApp('undefined.helper');
    }
}
