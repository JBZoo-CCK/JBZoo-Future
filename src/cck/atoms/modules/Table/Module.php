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

namespace JBZoo\CCK\Atom\Modules\Table;

use JBZoo\CCK\Table\Table;

/**
 * Class Module
 *
 * @package JBZoo\CCK\Atom\Modules\Table
 */
class Module extends Table
{
    /**
     * @inheritdoc
     */
    public function __construct($name = '', $key = 'id')
    {
        parent::__construct(JBZOO_TABLE_MODULES);
    }

    /**
     * Get module list.
     *
     * @return array
     */
    public function getList()
    {
        $sql    = $this->_select([$this->_table])->limit(100);
        $rows   = $this->_db->fetchAll($sql);
        $result = $this->_fetchObjectList($rows);

        return $result;
    }

    /**
     * Add new module.
     *
     * @param array $data
     * @return bool|int
     */
    public function add(array $data)
    {
        $sql = $this->_insert($this->_table)->row($data);
        return $this->_db->query($sql);
    }
}
