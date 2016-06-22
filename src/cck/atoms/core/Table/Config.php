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

namespace JBZoo\CCK\Atom\Core\Table;

use JBZoo\CCK\Table\Table;
use JBZoo\Data\Data;
use JBZoo\Data\JSON;

/**
 * Class Config
 * @package JBZoo\CCK
 */
class Config extends Table
{
    /**
     * @var Data
     */
    protected $_store;

    /**
     * @inheritdoc
     */
    public function __construct($name = '', $key = 'id')
    {
        parent::__construct(JBZOO_TABLE_CONFIG, '');

        $this->_store = $this->_init();
    }

    /**
     * @return Data
     */
    protected function _init()
    {
        if ($this->_store) {
            return $this->_store;
        }

        $select = $this->_select([$this->_table, 'tConfig'])
            ->select(['tConfig.option', 'tConfig.value'])
            ->where(['tConfig.autoload', ' = ?i'], 1)
            ->limit(10000);

        $rows = $this->_db->fetchAll($select);

        $tmp = [];
        foreach ($rows as $row) {
            $tmp[$row['option']] = $this->_decode($row['value']);
        }

        return jbdata($tmp);
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param mixed  $filter
     * @return mixed
     */
    public function get($key, $default, $filter = null)
    {
        return $this->_store->get($key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param mixed  $filter
     * @return mixed
     */
    public function find($key, $default, $filter = null)
    {
        return $this->_store->find($key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $newValue
     * @param bool   $isMerge
     */
    public function set($key, $newValue, $isMerge = true)
    {
        $oldValues = $this->_store->get($key);
        if (($isMerge) &&
            ($oldValues) &&
            (is_array($newValue) || $newValue instanceof Data) &&
            (is_array($oldValues) || $oldValues instanceof Data)
        ) {
            $newValue = array_replace_recursive((array)$oldValues, (array)$newValue);
            $this->_store->set($key, $this->_decode($newValue));
        } else {
            $this->_store->set($key, $newValue);
        }

        $replace = $this->_replace('#__jbzoo_config')->row([
            'option' => $key,
            'value'  => $this->_encode($newValue)
        ]);

        $this->_db->query($replace);
    }

    /**
     * @param $value
     * @return array|mixed|object
     */
    protected function _decode($value)
    {
        return new JSON($value);
    }

    /**
     * @param $value
     * @return array|mixed|object
     */
    protected function _encode($value)
    {
        return json_encode($value, JSON_PRETTY_PRINT);
    }
}
