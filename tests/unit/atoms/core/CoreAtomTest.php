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

/**
 * Class CoreAtomTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class AtomCoreTest extends JBZooPHPUnit
{
    public function testAtom()
    {
        isClass('\JBZoo\CCK\Atom\Core\Core', $this->app['atoms']['core']);
        isClass('\JBZoo\CCK\Atom\Core\Core', jbatom('core'));

        isSame(jbatom('core'), $this->app['atoms']['core']);
    }

    public function testGetResultOfController()
    {
        isSame(123456, $this->app->execute('test.index.checkReturn'));
    }

    public function testCallControllerByArgs()
    {
        $contentOnMain = 'JBZoo CCK';

        $uniqid = uniqid();
        $this->app['request']->set('uniqid', $uniqid);

        is($uniqid, $this->app->execute('test.index.index'));
        is($uniqid, $this->app->execute('test.index'));
        is($uniqid, $this->app->execute('test'));

        is($uniqid, $this->app->execute('Test.Index.Index'));
        is($uniqid, $this->app->execute(' Test.Index.Index '));
        is($uniqid, $this->app->execute(' Test . Index . Index '));
        is($uniqid, $this->app->execute(' T e s t . I n d e x . I n d e x '));
        is($uniqid, $this->app->execute(' T e s t . I n d e x . I n d e x . no check'));

        isContain($contentOnMain, $this->app->execute('.'));
        isContain($contentOnMain, $this->app->execute('....'));
        isContain($contentOnMain, $this->app->execute(''));
        isContain($contentOnMain, $this->app->execute(null));
        isContain($contentOnMain, $this->app->execute());
    }

    public function testLoadAllAtoms()
    {
        isTrue(is_array($this->app['route']->loadAllAtoms()));
    }
}
