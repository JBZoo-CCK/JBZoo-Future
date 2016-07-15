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

use JBZoo\Utils\FS;
use JBZoo\CCK\Renderer\Renderer;

/**
 * Class Framework_RendererTest
 * @package JBZoo\PHPUnit
 */
class Framework_RendererTest extends JBZooPHPUnit
{

    public function testCheckManagerClassName()
    {
        isClass('JBZoo\CCK\Renderer\Manager', $this->app['renderer']);
        isClass('JBZoo\CCK\Renderer\DefaultRenderer', $this->app['renderer']['default']);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception
     */
    public function testAddDefinedRenderer()
    {
        $this->app['renderer']->add('default');
        $this->app['renderer']->add('Default');
    }

    public function testAddClassPath()
    {
        $this->app['renderer']->addClassPath('\JBZoo\CCK\Atom\Item\\');
        $expected = [
            '\JBZoo\CCK\Atom\Item\\',
            '\JBZoo\CCK\Renderer\\',
        ];

        isSame($expected, $this->app['renderer']->getClassPaths());

        $this->app['renderer']->removeClassPath('\JBZoo\CCK\Atom\Item\\');

        $actual = $this->app['renderer']->getClassPaths();
        isTrue(in_array('\JBZoo\CCK\Renderer\\', $actual));
        isSame(1, count($actual));
    }

    public function testGetClassPaths()
    {
        $actual = $this->app['renderer']->getClassPaths();
        isTrue(in_array('\JBZoo\CCK\Renderer\\', $actual));
        isSame(1, count($actual));
    }

    public function testAddNotFoundNewRenderer()
    {
        $this->app['renderer']->add('custom');
        isClass('JBZoo\CCK\Renderer\DefaultRenderer', $this->app['renderer']['custom']);
    }

    public function testAddItemRenderer()
    {
        $this->app['renderer']->addClassPath('\JBZoo\CCK\Atom\Items\Renderer\\')->add('item');
        isClass('JBZoo\CCK\Atom\Items\Renderer\ItemRenderer', $this->app['renderer']['item']);
    }
    
    public function testAddPathsByString()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');

        $renderer->addPath($path);
        $actual = $this->app['path']->get(Renderer::PATH_ALIAS . ':');

        isSame(FS::clean($path . '/renderer', '/'), $actual);
        $this->_cleanPath();
    }

    public function testAddPathsByArray()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');

        $renderer->addPath([$path]);
        $actual = $this->app['path']->get(Renderer::PATH_ALIAS . ':');

        isSame(FS::clean($path . '/renderer', '/'), $actual);
        $this->_cleanPath();
    }

    public function testRenderSuccess()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');

        $actual = $renderer->addPath($path)->render('item.Test', ['name' => 'test']);
        isSame('item test file', $actual);

        $actual = $renderer->addPath($path)->render('item.test', ['name' => 'test']);
        isSame('item test file', $actual);

        $this->_cleanPath();
    }

    public function testRenderFail()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');
        $actual   = $renderer->addPath($path)->render('item.NotFound');
        $this->_cleanPath();

        isNull($actual);
    }

    protected function _cleanPath()
    {
        $this->app['path']->remove(Renderer::PATH_ALIAS, realpath($this->app['path']->get('atom-test:')));
    }
}
