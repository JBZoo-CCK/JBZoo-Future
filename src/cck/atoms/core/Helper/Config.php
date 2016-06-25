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

namespace JBZoo\CCK\Atom\Core\Helper;

use JBZoo\CCK\Atom\Core\Table\Config as ConfigTable;
use JBZoo\CCK\Atom\Helper;

/**
 * Class Config
 * @package JBZoo\CCK
 */
class Config extends Helper
{
    /**
     * @var ConfigTable
     */
    protected $_model = null;

    /**
     * {@inheritdoc}
     */
    protected function _init()
    {
        $this->_model = new ConfigTable();
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param null   $filter
     * @return mixed
     *
     * @deprecated
     */
    public function get($key, $default = null, $filter = null)
    {
        $key = $this->_prepareKey($key);
        return $this->_model->find($key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param null   $filter
     * @return mixed
     */
    public function find($key, $default = null, $filter = null)
    {
        $key = $this->_prepareKey($key);
        return $this->_model->find($key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $newValue
     * @param bool   $isMerge
     * @return bool|int
     */
    public function set($key, $newValue, $isMerge = true)
    {
        $key = $this->_prepareKey($key);
        return $this->_model->set($key, $newValue, $isMerge);
    }

    /**
     * @param string|array $key
     * @return string
     */
    protected function _prepareKey($key)
    {
        $key = is_array($key) ? implode('.', $key) : $key;
        $key = trim(strtolower($key));

        return $key;
    }
}
