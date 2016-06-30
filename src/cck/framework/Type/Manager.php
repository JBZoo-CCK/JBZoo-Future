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

namespace JBZoo\CCK\Type;

use JBZoo\CCK\Container;
use JBZoo\CCK\Exception\Exception;
use JBZoo\Utils\Filter;

/**
 * Class Manager
 */
class Manager extends Container
{
    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function offsetGet($id)
    {
        $id = Filter::cmd($id);

        if (!$this->offsetExists($id)) {
            $this[$id] = function () use ($id) {
                $typeObject = new Type($id);
                $typeObject->init();

                return $typeObject;
            };
        }

        return parent::offsetGet($id);
    }

    /**
     * Remove all types froma memory cache
     */
    public function cleanObjects()
    {
        $keys = $this->keys();

        foreach ($keys as $key) {
            unset($this[$key]);
        }
    }
}
