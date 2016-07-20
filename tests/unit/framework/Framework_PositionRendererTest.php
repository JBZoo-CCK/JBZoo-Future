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

use JBZoo\CCK\Entity\Item;

/**
 * Class Framework_PositionRendererTest
 * @package JBZoo\PHPUnit
 */
class Framework_PositionRendererTest extends JBZooPHPUnit
{

    protected $_type = 'item-type';

    public function testGetConfig()
    {
        $renderer = $this->app['renderer'];
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        isClass('JBZoo\CCK\Atom\Items\Renderer\ItemRenderer', $itemRenderer);

        $config = $itemRenderer->getConfig($this->_type . '.full');
        isClass('JBZoo\Data\JSON', $config);
    }

    public function testGetPositions()
    {
        $renderer = $this->app['renderer'];
        $path     = $this->app['path']->get('atom-test:');
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        $positions    = $itemRenderer->addPath($path)->getPositions($this->_type . '.full');

        isClass('JBZoo\Data\JSON', $positions);
        isSame('full', $positions->get('name'));
        isTrue(is_array($positions->get('positions')));
        isSame(3, count($positions->get('positions')));
    }

    public function testCheckPosition()
    {
        $layout   = 'full';
        $renderer = $this->app['renderer'];
        $path     = $this->app['path']->get('atom-test:');
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        $itemRenderer
            ->addPath($path)
            ->setLayout($layout)
            ->setItem($this->_getItem());

        $actual = $itemRenderer->checkPosition('title');
        isTrue($actual);

        $actual = $itemRenderer->checkPosition('content');
        isTrue($actual);

        $actual = $itemRenderer->checkPosition('one-of-two');
        isTrue($actual);

        $actual = $itemRenderer->checkPosition('properties');
        isFalse($actual);

        $actual = $itemRenderer->checkPosition('scope');
        isFalse($actual);
    }

    public function testRenderPosition()
    {
        $layout   = 'full';
        $renderer = $this->app['renderer'];
        $path     = $this->app['path']->get('atom-test:');
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        $itemRenderer
            ->addPath($path)
            ->setLayout($layout)
            ->setItem($this->_getItem());

        $actual = $itemRenderer->renderPosition('title');
        isContain('Name of test', $actual);
        isContain('PHPUnit testing Some test words', $actual);

        $actual = $itemRenderer->renderPosition('content');
        isSame('Custom alt label Some test words', $actual);

        $actual = $itemRenderer->renderPosition('one-of-two');
        isSame('  2', $actual);

        $actual = $itemRenderer->renderPosition('bottom');
        isSame('', $actual);

        $actual = $itemRenderer->renderPosition('scope');
        isSame('', $actual);

        $actual = $itemRenderer->renderPosition('properties');
        isSame('', $actual);
    }

    public function testGetPositionElements()
    {
        $layout   = 'full';
        $renderer = $this->app['renderer'];
        $path     = $this->app['path']->get('atom-test:');
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        $itemRenderer
            ->addPath($path)
            ->setLayout($layout)
            ->setItem($this->_getItem());

        $elements = $itemRenderer->getPositionElements('title');
        isSame(2, count($elements));

        $elements = $itemRenderer->getPositionElements('content');
        isSame(1, count($elements));

        $elements = $itemRenderer->getPositionElements('one-of-two');
        isSame(2, count($elements));

        $elements = $itemRenderer->getPositionElements('scope');
        isSame(3, count($elements));

        $elements = $itemRenderer->getPositionElements('no-exist');
        isSame(0, count($elements));
    }

    public function testItemRender()
    {
        $layout   = 'full';
        $renderer = $this->app['renderer'];
        $path     = $this->app['path']->get('atom-test:');
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        $itemRenderer
            ->addPath($path)
            ->setLayout($layout)
            ->setItem($this->_getItem());

        $content = $itemRenderer->render($this->_type . '.' . $layout);
        $this->_assertsItemRender($content);
    }

    public function testItemRenderIntegration()
    {
        $content = $this->helper->request('test.index.itemRenderFull');
        $this->_assertsItemRender($content);
    }

    protected function _assertsItemRender($content)
    {
        isTrue((bool) strpos($content, 'class="item-type-full">'));
        isTrue((bool) strpos($content, '<div class="item-title">'));
        isTrue((bool) strpos($content, 'Name of test'));
        isTrue((bool) strpos($content, 'PHPUnit testing Some test words'));
    }

    /**
     * @return Item
     */
    protected function _getItem()
    {
        return $this->app['models']['item']->get(1);
    }
}
