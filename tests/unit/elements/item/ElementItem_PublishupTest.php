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
 * Class ElementItem_PublishUpTest
 */
class ElementItem_PublishUpTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Publishup', 'item');
        isClass('\JBZoo\CCK\Element\Item\Publishup', $element);
    }

    public function testSave()
    {
        $item = new Item(['type' => 'for-validation']);

        isFalse($item->getElement('_publishup')->hasValue());

        $item->save();
        isTrue($item->getElement('_publishup')->hasValue());

        $currentDate = $this->app['date']->format(time(), 'sql');
        $item->save();

        $item->publish_up = $currentDate;
        isTrue($item->getElement('_publishup')->hasValue());

        $item->save();
        isTrue($item->getElement('_publishup')->hasValue());
    }
}
