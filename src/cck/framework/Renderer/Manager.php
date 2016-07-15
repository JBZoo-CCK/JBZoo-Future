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

namespace JBZoo\CCK\Renderer;

use JBZoo\CCK\Container;
use JBZoo\CCK\Exception;
use JBZoo\Utils\Arr;
use JBZoo\Utils\Str;

/**
 * Class Manager
 * @package JBZoo\CCK\Renderer
 */
class Manager extends Container
{

    /**
     * Renderer name space list.
     * @var array
     */
    protected $_classPaths = [
        '\JBZoo\CCK\Renderer\\'
    ];

    /**
     * @var array
     */
    protected $_renders = [];

    /**
     * Add new renderer.
     * @param string $name
     * @throws Exception
     */
    public function add($name)
    {
        $id = Str::low($name);
        $className = $this->_findRenderer($id);

        if (!isset($this->_renders[$id])) {
            $this->_register($id, $className);
        } else {
            throw new Exception("Renderer \"{$className}\" already defined!");
        }
    }

    /**
     * Add renderer class path.
     * @param array|string $paths
     * @return $this
     */
    public function addClassPath($paths)
    {
        $paths = (array) $paths;
        foreach ($paths as $path) {
            array_unshift($this->_classPaths, $path);
        }

        return $this;
    }

    /**
     * Get all class paths.
     * @return array
     */
    public function getClassPaths()
    {
        return $this->_classPaths;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function offsetGet($id)
    {
        $id = Str::low($id);
        if (!isset($this->_renders[$id])) {
            $className = $this->_findRenderer($id);
            $this->_register($id, $className);
        }

        return parent::offsetGet($id);
    }

    /**
     * Remove class path from renderer list.
     * @param string $path
     * @return $this
     */
    public function removeClassPath($path)
    {
        foreach ($this->_classPaths as $id => $classPath) {
            if ($classPath === $path) {
                unset($this->_classPaths[$id]);
                continue;
            }
        }

        return $this;
    }

    /**
     * Find renderer class.
     * @param string $name
     * @return null|string
     */
    protected function _findRenderer($name)
    {
        foreach ($this->_classPaths as $path) {
            $className = $this->_getClassName($path, $name);
            if (class_exists($className)) {
                return $className;
            }
        }

        return null;
    }

    /**
     * Put to container renderer class.
     * @param string $id
     * @param $className
     */
    protected function _register($id, $className)
    {
        if ($className !== null) {
            $this->_renders[$id] = $className;
            $this[$id] = function () use ($className) {
                /** @var Renderer $rendererObj */
                $rendererObj = new $className();
                return $rendererObj;
            };
        } else {
            $this->_renders[$id] = $this->_findRenderer('Default');
            $this[$id] = function () {
                return new DefaultRenderer();
            };
        }
    }

    /**
     * @param string $path
     * @param string $name
     * @return string
     */
    protected function _getClassName($path, $name)
    {
        return $path . ucfirst($name) . 'Renderer';
    }
}
