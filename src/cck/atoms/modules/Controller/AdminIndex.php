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

namespace JBZoo\CCK\Atom\Modules\Controller;

use JBZoo\CCK\Controller\Admin;
use JBZoo\CCK\Atom\Modules\Entity\Module;

/**
 * Class AdminIndex
 *
 * @package JBZoo\CCK\Atom\Modules\Controller
 */
class AdminIndex extends Admin
{

    /**
     * @var \JBZoo\CCK\Atom\Modules\Table\Module
     */
    protected $_table;

    /**
     * AdminIndex constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_table = $this->app['models']['module'];
    }

    /**
     * Index action.
     *
     * @return void
     */
    public function index()
    {
        $modules = $this->_table->getList();

        $tmp = [];
        /** @var Module $module */
        foreach ($modules as $module) {
            $tmp[$module->id] = $module;
        }

        $this->_json(['list' => $tmp]);
    }

    /**
     * Add new module action.
     *
     * @return void
     */
    public function add()
    {
        $data = $this->app['request']->getJSON('module');
        $entity = new Module($data);
        $entity->save();

        $this->_json(['module' => $entity->toArray()]);
    }

    /**
     * Update module data action.
     *
     * @return void
     */
    public function update()
    {
        $data = $this->app['request']->getJSON('module');
        $module = new Module($data);
        $module->save();

        $this->_json(['module' => $module]);
    }

    /**
     * Remove module action.
     *
     * @return void
     */
    public function remove()
    {
        $id = $this->app['request']->getJSON('id');

        /** @var Module $module */
        if ($module = $this->_table->get($id)) {
            $module->remove();
            $this->_json(['removed' => $id]);
        }

        $this->_json(['removed' => '0']);
    }
}
