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

use JBZoo\Utils\Str;

/**
 * Class Access
 */
class Alias extends Item
{
    /**
     * @inheritdoc
     */
    public function validate()
    {
        parent::validate();

        $item  = $this->getEntity();

        if (!$item->alias) {
            $item->alias = Str::slug($item->name ?: 'New item');
        }

        if ($item->alias && $item->alias !== Str::slug($item->alias)) {
            $this->_throwError("Invalid alias: '{$item->alias}', ItemId: {$item->id}");
        }

        $item->alias = $this->app['models']['item']->getUniqueAlias($item->id, Str::slug($item->alias));
    }
}
