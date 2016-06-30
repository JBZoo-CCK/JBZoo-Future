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
        parent::__construct(JBZOO_TABLE_CONFIG, 'option');
    }

    /**
     * @return Data
     */
    public function init()
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

        $this->_store = jbdata($tmp);
    }

    /**
     * Clean autoloaded store (cache in memory)
     */
    public function cleanCache()
    {
        $this->_store = jbdata();
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param mixed  $filter
     * @return mixed
     */
    public function find($key, $default = null, $filter = null)
    {
        $value = $this->_store->find($key, null, $filter);

        if (null === $value) { // Lazyload options

            $select = $this->_select([$this->_table, 'tConfig'])
                ->select(['tConfig.value'])
                ->where(['tConfig.option', '= ?s'], $key)
                ->limit(1);

            if ($row = $this->_db->fetchRow($select)) {
                $this->_store->set($key, $this->_decode($row['value']));
            } else {
                $this->_store->set($key, $default);
            }
        }

        return $this->_store->get($key, $default, $filter);
    }

    /**
     * @param string $key
     * @param mixed  $newValue
     * @param bool   $isMerge
     * @return bool|int
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

        $replace = $this->_replace($this->_table)->row([
            'option' => $key,
            'value'  => $this->_encode($newValue)
        ]);

        return $this->_db->query($replace);
    }

    /**
     * @inheritdoc
     */
    public function remove($id)
    {
        $this->_store->remove($id);
        return parent::remove($id);
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
