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
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function test()
    {
        $this->app->execute(null);
    }

    public function testLoadAllAtoms()
    {
        isTrue(is_array($this->app['route']->loadAllAtoms()));
    }

    public function testTableManager()
    {
        isClass('\JBZoo\CCK\Table\Manager', $this->app['models']);
        isClass('\JBZoo\CCK\Atom\Core\Table\Config', $this->app['models']['config']);
        isClass('\JBZoo\CCK\Atom\Items\Table\Item', $this->app['models']['item']);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testUndefinedModelTable()
    {
        $this->app['models']['undefined'];
    }
}
