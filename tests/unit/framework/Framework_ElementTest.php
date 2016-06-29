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
 * Class Framework_ElementTest
 */
class Framework_ElementTest extends JBZooPHPUnit
{
    public function testCreateElement()
    {
        $element = $this->app['elements']->create('Name');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);

        $element = $this->app['elements']->create('Name', 'item');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);

        $element = $this->app['elements']->create('Name', 'Item');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);
    }

    public function testElementCoreFeatures()
    {
        $element = $this->app['elements']->create('Name');

        isSame(true, $element->isCore());
        isSame('_name', $element->id);
        isTrue($element->getPath());

        isClass('\JBZoo\Data\Data', $element->config);
        isClass('\JBZoo\Data\Data', $element->loadMeta());
        isSame('Name', $element->getName());

        isSame([], $element->data());
    }

    public function testElementNotCoreFeatures()
    {
        $element1 = $this->app['elements']->create('Text');
        $element2 = $this->app['elements']->create('Text');

        isSame(false, $element1->isCore());
        is(10, strlen($element1->id));
        is(10, strlen($element2->id));

        isNotSame($element1, $element2);
        isNotSame($element1->id, $element2->id);
    }

    public function testGetElementType()
    {
        $element = $this->app['elements']->create('Text');

        isSame('text', $element->getElementType());
        isSame('Text', $element->getElementType(true));
        isSame('text', $element->getElementType(false));
    }

    public function testGetElementGroup()
    {
        $element = $this->app['elements']->create('Text');

        isSame('item', $element->getElementGroup());
        isSame('Item', $element->getElementGroup(true));
        isSame('item', $element->getElementGroup(false));
    }

    public function testGetEntity()
    {
        $element = $this->app['elements']->create('Text');
        isNull($element->getEntity());
    }
}
