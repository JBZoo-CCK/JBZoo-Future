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

use JBZoo\CCK\Element\Element;
use JBZoo\CCK\Entity\Item as ItemEntity;

/**
 * Class Item
 * @package JBZoo\CCK
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Item extends Element
{
    /**
     * @var ItemEntity
     */
    protected $_entity;

    /**
     * @inheritdoc
     */
    public function __construct($type, $group)
    {
        parent::__construct($type, 'Item');
    }

    /**
     * @return ItemEntity
     */
    public function getEntity()
    {
        return parent::getEntity();
    }
}
