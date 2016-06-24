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
 * Class CoreElementTest
 */
class CoreElementTest extends JBZooPHPUnit
{
    public function testCreateElement()
    {
        $element = $this->app['elements']->create('Name');

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
}
