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

    public function testGetHelper()
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

    public function testRequestedControllerEchoGET()
    {
        $uniq = uniqid('var');

        $this->app['request']->set('qwerty', $uniq);

        $actual = $this->app->execute('test.other', strtolower('checkEcho')); // check case-insensetive

        isSame($uniq, $actual);
        isSame($uniq, $_GET['qwerty']);
    }

    public function testGetResultOfController()
    {
        isSame(123456, $this->app->execute('test.index', 'checkReturn'));
    }
}
