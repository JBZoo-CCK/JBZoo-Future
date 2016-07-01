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
 * Class PublishUp
 */
class PublishUp extends Item
{
    /**
     * @inheritdoc
     */
    public function hasValue(Data $params = null)
    {
        $item = $this->getEntity();

        return !$item->publish_up || $item->publish_up !== Dates::SQL_NULL;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item = $this->getEntity();

        if ($item->isNew()) {
            $item->publish_up = $this->app['date']->format();
        } else {
            $item->publish_up = $this->app['date']->format($item->publish_up);
        }
    }
}
