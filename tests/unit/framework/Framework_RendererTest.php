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

    public function testAddNotFoundNewRenderer()
    {
        $this->app['renderer']->add('test-atom', 'application');
        $this->app['renderer']->add('users-atom', 'profile');

        isClass('JBZoo\CCK\Renderer\DefaultRenderer', $this->app['renderer']['application']);
        isClass('JBZoo\CCK\Renderer\DefaultRenderer', $this->app['renderer']['profile']);
    }

    public function testAddCurrentNewRenderer()
    {
        $render = $this->app['renderer'];
        $render->add('items', 'item');
        isClass('JBZoo\CCK\Atom\Items\Renderer\ItemRenderer', $render['item']);

        $render = $this->app['renderer'];
        $render->add('items', 'Item');
        isClass('JBZoo\CCK\Atom\Items\Renderer\ItemRenderer', $render['item']);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception
     */
    public function testAddDefinedRenderer()
    {
        $render = $this->app['renderer'];
        $render->add('test-atom', 'test');
        $render->add('test-atom', 'test');
    }

    public function testRenderSuccess()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');
        $content  = $renderer->addPath($path)->render('item-type.Test', ['name' => 'test']);

        isSame('item test file', $content);
    }

    public function testRenderNotFoundLayout()
    {
        /** @var Renderer $renderer */
        $renderer = $this->app['renderer']['default'];
        $path     = $this->app['path']->get('atom-test:');
        $content  = $renderer->addPath($path)->render('item-type.NotFound', ['name' => 'test']);
        isNull($content);
    }
}
