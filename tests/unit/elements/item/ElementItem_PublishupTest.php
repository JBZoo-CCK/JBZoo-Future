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
 * Class ElementItem_PublishUpTest
 */
class ElementItem_PublishUpTest extends JBZooPHPUnit
{
    public function testCreate()
    {
        $element = $this->app['elements']->create('Publishup', 'item');
        isClass('\JBZoo\CCK\Element\Item\Publishup', $element);
    }
}
