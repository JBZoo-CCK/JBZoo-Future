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

/**
 * Class AtomModules_TableModuleTest
 */
class AtomModules_TableModuleTest extends JBZooPHPUnit
{
    /**
     * @return \JBZoo\CCK\Atom\Modules\Table\Module
     */
    protected function _table()
    {
        return $this->app['models']['module'];
    }

    public function testClassName()
    {
        isClass('\JBZoo\CCK\Atom\Modules\Table\Module', $this->_table());
        isSame('#__jbzoo_modules', JBZOO_TABLE_MODULES);
    }

    public function testGetList()
    {
        $actual = $this->_table()->getList();
        isSame(4, count($actual));
    }

    public function testRemove()
    {
        $this->_table()->remove(1);
        isSame(3, count($this->_table()->getList()));
    }

    public function testGet()
    {
        $module1 = $this->_table()->get(1);
        $module2 = $this->_table()->get(1);
        isSame($module1, $module2);
    }

    public function testAdd()
    {
        $data = [
            'title'  => 'New test module',
            'params' => 'My custom params',
        ];

        $this->_table()->add($data);

        isSame(5, count($this->_table()->getList()));

        /** @var \JBZoo\CCK\Atom\Modules\Entity\Module $module */
        $module = $this->_table()->get(5);
        isSame($data['title'], $module->title);
        isSame($data['params'], $module->params);
    }

    public function testEntityClassName()
    {
        isClass('JBZoo\CCK\Atom\Modules\Entity\Module', $this->_table()->get(1));
    }

    public function testUpdate()
    {
        $module         = new Module();
        $module->title  = 'New module';
        $module->params = 'new-module';
        is(5, $module->save());

        is(5, $module->id);
        isSame('New module', $module->title);
        isSame('new-module', $module->params);

        $module->title = 'Another name';
        is(5, $module->save());

        $this->_table()->cleanObjects();
        /** @var Module $newModule */
        $newModule = $this->_table()->get(5);
        is(5, $newModule->id);
        isSame('Another name', $newModule->title);
        isSame('new-module', $newModule->params);
    }
}
