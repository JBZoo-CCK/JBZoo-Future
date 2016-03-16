<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

namespace JBZoo\PHPUnit;

use JBZoo\CCK\App;

/**
 * Class ApplicationTest
 * @package JBZoo\PHPUnit
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

    public function testGetDebuger()
    {
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['atoms']['core']['debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['core.debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', $this->app['debug']);
        isClass('\JBZoo\CCK\Atom\Core\Helper\Debug', jbd());
        isClass('\JBZoo\CCK\Atom\Helper', $this->app['debug']);

        isSame($this->app['atoms']['core']['debug'], $this->app['debug']);
        isSame($this->app['atoms']['core']['debug'], $this->app['core.debug']);
        isSame($this->app['debug'], $this->app['core.debug']);
    }

    public function testGetResultOfController()
    {
        isSame(123456, $this->app->execute('test.index', 'checkReturn'));
    }
}
