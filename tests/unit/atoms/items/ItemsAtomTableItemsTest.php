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
 * Class ItemsAtomTableItemsTest
 */
class ItemsAtomTableItemsTest extends JBZooPHPUnit
{
    public function testClassName()
    {
        $itemTable = $this->app['models']['items'];
        isClass('\JBZoo\CCK\Atom\Items\Table\Items', $itemTable);
    }

    public function testGetList()
    {
        $itemTable = $this->app['models']['items'];
        isSame([], $itemTable->getList());
    }
}
