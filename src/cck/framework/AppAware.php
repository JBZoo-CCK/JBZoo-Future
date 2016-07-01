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

namespace JBZoo\CCK;

/**
 * Class AppAware
 * @package JBZoo\CCK
 *
 * @codeCoverageIgnore
 */
abstract class AppAware implements \ArrayAccess
{
    /**
     * @var App
     */
    public $app;

    /**
     * appAware constructor.
     */
    public function __construct()
    {
        $this->app = App::getInstance();
    }

    /**
     * Whether an app parameter or an object exists.
     * @param  string $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return isset($this->app[$offset]);
    }

    /**
     * Gets parameter or an object.
     * @param  string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->app[$offset];
    }

    /**
     * Sets an app parameter or an object.
     * @param  string $offset
     * @param  mixed  $value
     */
    public function offsetSet($offset, $value)
    {
        $this->app[$offset] = $value;
    }

    /**
     * Unsets an app parameter or an object.
     * @param  string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->app[$offset]);
    }
}
