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

use JBZoo\Utils\Str;
use JBZoo\CCK\Container;
use JBZoo\CCK\Exception;

/**
 * Class Manager
 * @package JBZoo\CCK\Renderer
 */
class Manager extends Container
{

    /**
     * Renderer class name suffix.
     */
    const RENDERER_SUFFIX = 'Renderer';

    /**
     * Renderer lists.
     * @var array
     */
    protected $_renders = [];

    /**
     * Add new renderer.
     * @param string $atomId
     * @param string $class
     * @throws Exception
     */
    public function add($atomId, $class)
    {
        $id = Str::low($class);
        if (!isset($this->_renders[$id])) {
            $rendererClass = '\JBZoo\CCK\Atom\\' . ucfirst($atomId) . '\Renderer\\' . $this->_getClassName($class);
            $this->_register($id, $rendererClass);
        } else {
            throw new Exception("Renderer \"{{$atomId}.{$class}}\" already defined!");
        }
    }

    /**
     * {@inheritdoc}
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function offsetGet($id)
    {
        $id = Str::low($id);
        if (!isset($this->_renders[$id])) {
            $rendererClass = '\JBZoo\CCK\Renderer\\' . $this->_getClassName($id);
            $this->_register($id, $rendererClass);
        }

        return parent::offsetGet($id);
    }

    /**
     * @param string $class
     * @return string
     */
    protected function _getClassName($class)
    {
        $class = Str::low($class);
        return ucfirst($class) . self::RENDERER_SUFFIX;
    }

    /**
     * Put to container renderer class.
     * @param string $id
     * @param string $rendererClass
     * @throws Exception
     */
    protected function _register($id, $rendererClass)
    {
        if (class_exists($rendererClass)) {
            $this->_renders[$id] = $rendererClass;
            $this[$id] = function () use ($rendererClass) {
                /** @var Renderer $renderer */
                $renderer = new $rendererClass();
                return $renderer;
            };
        } else {
            $this->_renders[$id] = '\JBZoo\CCK\Renderer\\' . $this->_getClassName('Default');
            $this[$id] = function () {
                return new DefaultRenderer();
            };
        }
    }
}
