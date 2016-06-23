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
class ItemsAtomTableItemsTest extends JBZooPHPUnitDatabase
{
    protected $_fixtureFile = 'items.php';

    public function testClassName()
    {
        isClass('\JBZoo\CCK\Atom\Items\Table\Items', $this->app['models']['items']);
    }

    public function testGetList()
    {
        is(2, count($this->app['models']['items']->getList()));
    }
}
