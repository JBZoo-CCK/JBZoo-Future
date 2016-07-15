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

define('JBZOO_TABLE_POSITIONS', '#__jbzoo_positions');

/**
 * Class Position
 * @package JBZoo\CCK\Table
 */
class Position extends Table
{
    /**
     * @inheritdoc
     */
    public function __construct($name = '', $key = 'id')
    {
        parent::__construct(JBZOO_TABLE_POSITIONS);
    }

    /**
     * Get position data by layout.
     * @param string $layout
     * @return mixed
     */
    public function getByLayout($layout)
    {
        $sql    = $this->_select()->where('layout = ?i', $layout);
        $row    = $this->_db->fetchRow($sql);
        $object = $this->_fetchObject($row);

        return $object;
    }
}
