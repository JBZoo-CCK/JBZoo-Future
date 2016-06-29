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
 * Class Framework_AtomTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Framework_AtomTest extends JBZooPHPUnit
{
    public function testAtom()
    {
        isClass('\JBZoo\CCK\Atom\Core\Core', $this->app['atoms']['core']);
        isClass('\JBZoo\CCK\Atom\Core\Core', jbatom('core'));

        isSame(jbatom('core'), $this->app['atoms']['core']);
    }

    public function testAtomId()
    {
        isSame('core', $this->app['atoms']['core']->getId());
        isSame('test', $this->app['atoms']['test']->getId());
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

    public function testUndefinedAction()
    {
        $content = $this->helper->request('test.index.undefined');
        isContain('Action not found: test.index.undefined', $content->body);
    }

    public function testUndefinedController()
    {
        $content = $this->helper->request('test.undefined.index');
        isContain(
            'Controller not found: test.undefined; PHP Class: JBZoo\CCK\Atom\Test\Controller\SiteUndefined',
            $content->body
        );
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
        isClass('\JBZoo\CCK\Table\Item', $this->app['models']['item']); // default model
        isClass('\JBZoo\CCK\Atom\Core\Table\Config', $this->app['models']['config']); // custom model
    }

    public function testTableNames()
    {
        isSame(JBZOO_TABLE_ITEMS, $this->app['models']['item']->getTableName());
        isSame(JBZOO_TABLE_CONFIG, $this->app['models']['config']->getTableName());
    }

    public function testGetTableId()
    {
        isSame('item', $this->app['models']['item']->getId());
        isSame('config', $this->app['models']['config']->getId());
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testUndefinedModelTable()
    {
        $this->app['models']['undefined'];
    }
}
