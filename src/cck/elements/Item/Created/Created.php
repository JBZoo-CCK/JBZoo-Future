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
 * Class Created
 */
class Created extends Item
{
    /**
     * @inheritdoc
     */
    public function hasValue(Data $params = null)
    {
        $item = $this->getEntity();

        return !$item->created || $item->created !== '0000-00-00 00:00:00';
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item = $this->getEntity();

        if ($item->isNew()) {
            $item->created = $this->app['date']->format(time(), 'sql');
        }

        if (!Dates::is($item->created)) {
            $this->_throwError("Invalid created date: {$item->created}");
        }
    }
}
