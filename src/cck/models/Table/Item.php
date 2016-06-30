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

namespace JBZoo\CCK\Table;

define('JBZOO_TABLE_ITEMS', '#__jbzoo_items');

/**
 * Class Item
 * @package JBZoo\CCK
 */
class Item extends Table
{
    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_ARCHIVE  = 2;

    /**
     * @inheritdoc
     */
    public function __construct($name = '', $key = 'id')
    {
        parent::__construct(JBZOO_TABLE_ITEMS, 'id');
    }

    /**
     * @return array|null
     */
    public function getList()
    {
        $sql    = $this->_select($this->_table);
        $rows   = $this->_db->fetchAll($sql);
        $result = $this->_fetchObjectList($rows);

        return $result;
    }

    /**
     * Method to check if an alias already exists.
     *
     * @param string $newItemAlias
     * @param int    $itemId
     * @return bool
     */
    public function checkAlias($newItemAlias, $itemId)
    {
        $existedId = $this->aliasToId($newItemAlias);

        if ($existedId && $existedId != (int)$itemId) {
            return true;
        }

        return false;
    }

    /**
     * Convert item alias to id
     *
     * @param string $alias
     * @return string
     */
    public function aliasToId($alias)
    {
        $sql = $this->_select($this->_table)
            ->select('id')
            ->where('alias = ?s', $alias)
            ->limit(1);

        $row = $this->_db->fetchRow($sql);

        return $row['id'] ? $row['id'] : 0;
    }
}
