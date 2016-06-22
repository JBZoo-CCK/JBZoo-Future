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

namespace JBZoo\CCK\Atom\Items\Table;

use JBZoo\CCK\Atom\Items\Entity\Item;
use JBZoo\CCK\Table\Table;

/**
 * Class Items
 * @package JBZoo\CCK
 */
class Items extends Table
{
    const STATUS_UNACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_HIDDEN   = 2;

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
        $sql = $this->_select($this->_table)
            ->where('state <> ?i', self::STATUS_UNACTIVE)
            ->limit(100);

        $rows = $this->_db->fetchAll($sql);

        $result = [];
        foreach ($rows as $row) {
            $item = $this->app['entities']['item'];
            $item->bindData($row);
            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param int $itemId
     * @return array
     */
    public function get($itemId = 0)
    {
        $sql = $this->_select($this->_table)
            ->where('state <> ?i', self::STATUS_UNACTIVE)
            ->where('id = ?i', $itemId)
            ->limit(1);

        $row = $this->_db->fetchRow($sql);

        $item = $this->app['entities']['item'];
        $item->bindData($row);

        return $item;
    }
}
