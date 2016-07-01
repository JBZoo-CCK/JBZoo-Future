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
use JBZoo\CCK\Exception;
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

    /**
     * @return array
     */
    public function getRequiredElements()
    {
        return [
            '_id'          => ['type' => 'id', 'group' => 'item'],
            '_name'        => ['type' => 'name', 'group' => 'item'],
            '_alias'       => ['type' => 'alias', 'group' => 'item'],
            '_status'      => ['type' => 'status', 'group' => 'item'],
            '_createdby'   => ['type' => 'createdby', 'group' => 'item'],
            '_created'     => ['type' => 'created', 'group' => 'item'],
            '_modified'    => ['type' => 'modified', 'group' => 'item'],
            '_publishup'   => ['type' => 'publishup', 'group' => 'item'],
            '_publishdown' => ['type' => 'publishdown', 'group' => 'item'],
        ];
    }
}
