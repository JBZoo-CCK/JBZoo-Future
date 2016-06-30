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
use JBZoo\CCK\Element\Element;
use JBZoo\CCK\Element\Repeatable;
use JBZoo\CCK\Entity\Item;

/**
 * Class Framework_ElementTest
 */
class Framework_ElementTest extends JBZooPHPUnit
{
    protected function setUp()
    {
        parent::setUp();
        $this->app['models']['item']->cleanObjects();
    }

    public function testCreate()
    {
        $element = $this->app['elements']->create('Name');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);

        $element = $this->app['elements']->create('Name', 'item');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);

        $element = $this->app['elements']->create('Name', 'Item');
        isClass('\JBZoo\CCK\Element\Item\Name', $element);
    }

    public function testCoreFeatures()
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

    public function testNotCoreFeatures()
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

    public function testGetEmptyEntity()
    {
        $element = $this->app['elements']->create('Text');
        isNull($element->getEntity());
    }

    public function testRepeatableCreate()
    {
        $element = $this->app['elements']->create('TestRepeatable');

        isClass('\JBZoo\CCK\Element\Element', $element);
        isClass('\JBZoo\CCK\Element\Repeatable', $element);
        isClass('\JBZoo\CCK\Element\Item\ItemRepeatable', $element);
        isClass('\JBZoo\CCK\Element\Item\TestRepeatable', $element);
    }

    public function testIsRepeatable()
    {
        $element    = $this->app['elements']->create('Test');
        $elementRep = $this->app['elements']->create('TestRepeatable');

        isFalse($element->isRepeatable());
        isTrue($elementRep->isRepeatable());
    }

    public function testRepeatableData()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        isClass('\JBZoo\CCK\Element\Item\TestRepeatable', $element);

        isSame([
            ['value' => 'Value #1'],
            ['value' => 'Value #2'],
            ['value' => 'Value #3'],
        ], $element->data());

        isSame(3, count($element));

        $element = $this->app['elements']->create('TestRepeatable');
        isClass('\JBZoo\CCK\Element\Item\TestRepeatable', $element);
        isSame([], $element->data());
        isSame(0, count($element));
    }

    public function testRepeatableSeek()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        isTrue($element->seek(0));
        isTrue($element->seek(1));
        isTrue($element->seek(2));
        isFalse($element->seek(3));

        $element = $item->getElement('some-rep-empty');
        isFalse($element->seek(0));

        $element = $this->app['elements']->create('TestRepeatable');
        isFalse($element->seek(0));
        isFalse($element->seek(1));
    }

    public function testGetSearchData()
    {
        /** @var Item $item */
        /** @var Element $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-test');

        $expected = ['Value'];
        isSame($expected, $element->getSearchData());
    }

    public function testRepeatableGetSearchData()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        $expected = ['Value #1', 'Value #2', 'Value #3'];
        isSame($expected, $element->getSearchData());
    }

    public function testRepeatableRender()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        $expected = ['Value #1', 'Value #2', 'Value #3'];

        isSame(implode(PHP_EOL . ' ', $expected), $element->render());
        isSame(implode(PHP_EOL . ' ', $expected), $element->render(jbdata(['layout' => 'undefined'])));
        isSame(implode(', ', $expected), $element->render(jbdata(['separated_by' => ', '])));
    }

    public function testRepeatableKey()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        $keys = [];
        foreach ($element as $elementVal) {
            $keys[] = $element->key();
        }

        isSame([0, 1, 2], $keys);
    }

    public function testGetControlName()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        isSame('elements[some-repeatable][0][value]', $element->getControlName());
        isSame('elements[some-repeatable][0][value]', $element->getControlName());
        isSame('elements[some-repeatable][0][index]', $element->getControlName('index'));
        isSame('elements[some-repeatable][0][index][]', $element->getControlName('index', true));

        $element = $item->getElement('some-test');
        isSame('elements[some-test][value]', $element->getControlName());
        isSame('elements[some-test][value]', $element->getControlName());
        isSame('elements[some-test][index]', $element->getControlName('index'));
        isSame('elements[some-test][index][]', $element->getControlName('index', true));
    }

    public function testRepeatableHasValue()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item = $this->app['models']['item']->get(1);

        $element = $item->getElement('some-repeatable');
        isTrue($element->hasValue());

        $element = $item->getElement('some-rep-empty');
        isFalse($element->hasValue());

        $element = $item->getElement('some-test');
        isTrue($element->hasValue());

        $element = $this->app['elements']->create('TestRepeatable');
        isFalse($element->hasValue());
    }

    public function testRepeatableBindData()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        $element->bindData([
            [
                'value' => 'Value #4',
                'other' => 'Data'
            ]
        ]);

        isSame([
            [
                'value' => 'Value #4',
                'other' => 'Data'
            ],
        ], $element->data());
    }

    public function testRepeatableSetAndGet()
    {
        /** @var Item $item */
        /** @var Repeatable $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-repeatable');

        $element->set('option', 'Value');
        $element->next();
        $element->set('option-next', 'Value next');

        isSame([
            ['value' => 'Value #1', 'option' => 'Value'],
            ['value' => 'Value #2', 'option-next' => 'Value next'],
            ['value' => 'Value #3'],
        ], $element->data());
    }

    public function testBindData()
    {
        $unique1 = uniqid('value-');
        $unique2 = uniqid('value-');

        /** @var Item $item */
        /** @var Element $element */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-test');

        $element->set('content', $unique1);
        isSame($unique1, $element->get('content'));

        $element->set('content', $unique2);
        isSame($unique2, $element->get('content'));

        $newData = [
            'option-1' => $unique1,
            'option-2' => $unique2
        ];

        $element->bindData($newData);

        isSame($unique1, $element->get('option-1'));
        isSame($unique2, $element->get('option-2'));

        isSame($newData, $element->data());
    }

    public function testLoadAssets()
    {
        $content = $this->helper->request('test.element.checkLoadAssets');

        isContain('item_test_assets_less_test_less.css', $content->body);
        isContain('Item/Test/assets/css/test.css', $content->body);
        isContain('jbzoo-utils.min.js', $content->body);
        isContain('jbzoo-jquery-factory.min.js', $content->body);
        isContain('Item/Test/assets/js/test.js', $content->body);
        isContain('Item/Test/assets/jsx/test.jsx', $content->body);

        $element = $this->app['models']['item']->get(1)->getElement('some-test');
        isContain('<p class="test-element-rendering">' . $element->get('value') . '</p>', $content->body);
    }

    public function testHasValue()
    {
        /** @var Item $item */
        $item    = $this->app['models']['item']->get(1);
        $element = $item->getElement('some-test');

        isTrue($element->hasValue());
    }

    public function testGetEntity()
    {
        /** @var Item $item */
        $item = $this->app['models']['item']->get(1);

        $element = $item->getElement('some-test');

        isSame($item, $element->getEntity());
        isClass('\JBZoo\CCK\Entity\Entity', $element->getEntity());
        isClass('\JBZoo\CCK\Entity\Item', $element->getEntity());
    }

    public function testRender()
    {
        /** @var Item $item */
        $item = $this->app['models']['item']->get(1);

        $element = $item->getElement('some-test');

        $value = $element->get('value');

        isTrue($value);
        isSame($value, $element->render(jbdata()));

        $expected = "<p>{$value}</p>\n";
        isSame($expected, $element->render(jbdata(['layout' => 'custom-layout'])));
        isSame($expected, $element->render(jbdata(['layout' => 'custom-layout.php'])));
    }

    public function testRenderEvents()
    {
        /** @var Item $item */
        $item = $this->app['models']['item']->get(1);

        $element = $item->getElement('some-test');

        $eventName = "element.{$element->getElementGroup()}.{$element->getElementType()}.render.";

        // Add listners
        $this->app
            ->on("$eventName.before", function (App $app, Element $element, &$layout, array &$args) {
                $element->set('value', $args['params']->get('new_value'));
            })

            ->on("$eventName.after", function (App $app, Element $element, &$layout, array &$args, &$result) {
                $result .= '|' . $args['params']->get('add_text');
            });

        $newValue = uniqid('new-value-');
        $addText  = uniqid('add-text-');

        isTrue($newValue, $element->get('value'));

        // Excecute it!
        isSame($newValue . '|' . $addText, $element->render(jbdata([
            'new_value' => $newValue,
            'add_text'  => $addText,
        ])));
    }
}
