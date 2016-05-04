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

use JBZoo\Data\Data;
use JBZoo\Data\JSON;
use JBZoo\SqlBuilder\Query\Replace;
use JBZoo\SqlBuilder\Query\Select;

/**
 * Class Config
 * @package JBZoo\CCK
 */
class Config extends Core
{
    /**
     * @var Data
     */
    protected $_store;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        parent::__construct();

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

        $select = (new Select(['#__jbzoo_config', 'tConfig']))
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
     */
    public function set($key, $newValue)
    {
        $oldValues = $this->_store->get($key);

        if ($oldValues && (is_array($oldValues) || $oldValues instanceof Data)) {
            $newValue = array_replace_recursive((array)$oldValues, $newValue);
        }

        $this->_store->set($key, $newValue);

        $replace = (new Replace('#__jbzoo_config'))
            ->row([
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
