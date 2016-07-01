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

namespace JBZoo\CCK\Element\Item;

use JBZoo\CCK\Entity\Item as ItemEntity;
use JBZoo\Data\Data;

/**
 * Class State
 */
class Status extends Item
{
    protected $_validList = [
        ItemEntity::STATUS_ACTIVE,
        ItemEntity::STATUS_ARCHIVE,
        ItemEntity::STATUS_UNACTIVE
    ];

    /**
     * @inheritdoc
     */
    public function hasValue(Data $params = null)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item = $this->getEntity();

        $state = (int)$item->status;

        if (!in_array($state, $this->_validList, true)) {
            $state = ItemEntity::STATUS_UNACTIVE;
        }

        $item->status = $state;
    }
}
