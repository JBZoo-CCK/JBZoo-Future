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
 * Class Modules
 *
 * @package JBZoo\CCK\Atom\Modules\Table
 */
class Modules extends Table
{
    /**
     * @inheritdoc
     */
    public function __construct($name = '', $key = 'id')
    {
        parent::__construct(JBZOO_TABLE_MODULES);
    }

    /**
     * Table alias.
     *
     * @var string
     */
    protected $_alias = 'tModules';

    /**
     * Get module list.
     *
     * @return array
     */
    public function getList()
    {
        $select = $this->_select([$this->_table, $this->_alias])
            ->select([
                'tModules.id',
                'tModules.title',
                'tModules.params',
            ])
            ->limit(100);

        $return = [];
        $rows   = $this->_db->fetchAll($select);
        foreach ($rows as $row) {
            $return[$row['id']] = [
                'title'  => $row,
                'params' => jbdata((array) $row['params']),
            ];
        }

        return $return;
    }

    /**
     * Get module by id.
     *
     * @param int $id
     * @return mixed
     */
    public function get($id)
    {
        $sql = $this->_select([$this->_table, $this->_alias])->where('id = ?i', $id);
        return $this->_db->fetchRow($sql);
    }

    /**
     * Add new module.
     *
     * @param string $title
     * @param string $params
     * @return bool|int
     */
    public function add($title, $params)
    {
        $sql = $this->_insert($this->_table)->row([
            'title'  => $title,
            'params' => $params,
        ]);

        return $this->_db->query($sql);
    }

    /**
     * Delete module by id.
     *
     * @param int $id
     * @return bool|int
     */
    public function delete($id)
    {
        $sql = $this->_delete([$this->_table])->where('id = ?i', $id);
        return $this->_db->query($sql);
    }
}
