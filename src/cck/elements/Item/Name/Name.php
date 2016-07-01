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
use JBZoo\Utils\Str;

/**
 * Class Name
 */
class Name extends Item
{
    /**
     * @inheritdoc
     */
    public function hasValue(Data $params = null)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item = $this->getEntity();
        $name = $item->name ?: 'New item';

        $item->name = Str::limitChars($name, 255, '');
    }
}
