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

use JBZoo\CCK\Atom\Modules\Entity\Module;
use JBZoo\CCK\Entity\Item;

/**
 * Class Framework_EntityTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Framework_EntityTest extends JBZooPHPUnit
{
    public function testGetName()
    {
        $item = new Item();
        isSame('item', $item->getEntityName());

        $item = new Module();
        isSame('module', $item->getEntityName());
    }
}
