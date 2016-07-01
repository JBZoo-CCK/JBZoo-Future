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
 * Class ElementItem_PublishDownTest
 */
class ElementItem_PublishDownTest extends JBZooPHPUnit
{
    protected $_fixtureFile = 'Framework_ItemTest.php';

    public function testCreate()
    {
        $element = $this->app['elements']->create('Publishdown', 'item');
        isClass('\JBZoo\CCK\Element\Item\Publishdown', $element);
    }

    public function testSave()
    {
        $item = new Item(['type' => 'for-validation']);

        isFalse($item->getElement('_publishdown')->hasValue());

        $item->save();
        isFalse($item->getElement('_publishdown')->hasValue());

        $currentDate = $this->app['date']->format(time());
        $item->save();

        $item->publish_down = $currentDate;
        isTrue($item->getElement('_publishdown')->hasValue());

        $item->save();
        isTrue($item->getElement('_publishdown')->hasValue());
    }
}
