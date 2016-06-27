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
        $data = $this->app['request']->getJSON('data');
        $rows = json_decode($data, true);

        $entity = new Module();
        $entity->bindData($rows);
        $entity->save();

        $this->_json($entity->toArray());
    }

    /**
     * Update module data action.
     *
     * @return void
     */
    public function update()
    {
        $data = $this->app['request']->getJSON('data');
        $arrayData = json_decode($data, true);
        $entity = new Module();
        $entity->bindData($arrayData);
        $id = $entity->save();

        $this->_json(['module' => ['id' => $id]]);
    }
}
