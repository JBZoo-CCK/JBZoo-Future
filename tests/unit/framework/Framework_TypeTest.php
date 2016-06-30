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

use JBZoo\CCK\Type\Type;

/**
 * Class Framework_TypeTest
 */
class Framework_TypeTest extends JBZooPHPUnit
{
    public function testCreateType()
    {
        /** @var Type $type1 */
        /** @var Type $type2 */
        $type1 = $this->app['types']['some-Type'];
        $type2 = $this->app['types']['some-type'];

        isClass('\JBZoo\CCK\Type\Type', $type1);
        isSame($type1, $type2);
    }

    public function testTypeId()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        isSame('some-type', $type->id);
    }

    public function testTypeName()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        isSame('Type name', $type->getName());
    }

    public function testGetElement()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $nameElement1 = $type->getElement('_name');
        $nameElement2 = $type->getElement('_name');

        isNotSame($nameElement1, $nameElement2);

        $elementCore = $type->getElement('_name');
        $elementText = $type->getElement('test-id-random');

        isSame('_name', $elementCore->id);
        isSame('test-id-random', $elementText->id);
    }

    public function testGetUndefinedElement()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $nameElement = $type->getElement('undefined');
        isSame(null, $nameElement);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testInvalidElementConfig()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $nameElement = $type->getElement('no-valid-element-1');
        isSame(null, $nameElement);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testInvalidElementType()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $nameElement = $type->getElement('no-valid-element-2');
        isSame(null, $nameElement);
    }

    /**
     * @expectedException \JBZoo\CCK\Exception\Exception
     */
    public function testInvalidElementGroup()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $nameElement = $type->getElement('no-valid-element-3');
        isSame(null, $nameElement);
    }

    public function testGetElementConfig()
    {
        /** @var Type $type */
        $type = $this->app['types']['some-Type'];

        $elementConfig = $type->getElementConfig('test-id-random');

        isClass('\JBZoo\Data\Data', $elementConfig);
        isSame([
            'type'     => 'text',
            'group'    => 'item',
            'option-1' => 'Value 1',
            'option-2' => 'Value 2',
        ], (array)$elementConfig);

        $configUndefined = $type->getElementConfig('undefined');
        isSame(null, $configUndefined);
    }

    public function testSaveTypeConfig()
    {
        /** @var Type $type1 */
        $type1 = $this->app['types']['some-Type'];

        $type1->config->set('name', 'New type name');
        isTrue($type1->save());

        /** @var Type $type2 */
        $type2 = $this->app['types']['some-type'];

        isSame('New type name', $type2->getName());
    }

    public function testGetUndefinedType()
    {
        /** @var Type $type */
        $type = $this->app['types']['undefined'];

        isClass('\JBZoo\Data\Data', $type->config);
        isSame('undefined', $type->getName());

        isTrue($type->save());

        isSame('undefined', $type->config->get('name'));
    }

    public function testRemoveType()
    {
        /** @var Type $type */
        $type = $this->app['types']['New-Type'];

        isTrue($type->save());
        isSame(["name" => "new-type"], $this->app['cfg']->find("type.new-type"));

        isTrue($type->remove());
        isSame(null, $this->app['cfg']->find("type.new-type"));
    }

    public function testCreateInstances()
    {
        isSame($this->app['types']['New-Type'], $this->app['types']['new-type']);
    }

    public function testGetElements()
    {
        /** @var Type $type */
        $type = $this->app['types']['elements'];

        $elements = $type->getElements();
        isTrue(is_array($elements));
        isSame(3, count($elements));

        $elements = $type->getElements('all');
        isTrue(is_array($elements));
        isSame(3, count($elements));

        $elements = $type->getElements('core');
        isTrue(is_array($elements));
        isSame(2, count($elements));

        $elements = $type->getElements('custom');
        isTrue(is_array($elements));
        isSame(1, count($elements));

        /** @var Type $undefinedType */
        $undefinedType = $this->app['types']['undefined-type'];
        $elements      = $undefinedType->getElements();
        isTrue(is_array($elements));
        isSame(0, count($elements));
    }
}
