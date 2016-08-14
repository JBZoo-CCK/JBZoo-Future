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

use JBZoo\Data\Data;
use JBZoo\Utils\Dates;

/**
 * Class Publishdown
 */
class Publishdown extends Item
{
    /**
     * @inheritdoc
     */
    public function hasValue(Data $params = null)
    {
        $item = $this->getEntity();

        return !$item->publish_down || $item->publish_down !== Dates::SQL_NULL;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item = $this->getEntity();

        $item->publish_down = $this->app['date']->format($item->publish_down);
    }
}
