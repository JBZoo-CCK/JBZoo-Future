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

use JBZoo\Utils\FS;
use JBZoo\Utils\Arr;
use JBZoo\Utils\Str;
use JBZoo\CCK\Container;

/**
 * Class Renderer
 * @package JBZoo\CCK\Renderer
 */
abstract class Renderer extends Container
{

    const PATH_ALIAS = 'renderer';

    /**
     * The base folder.
     * @var string
     */
    protected $_folder = 'renderer';

    /**
     * @var string
     */
    protected $_ext = '.php';

    /**
     * @var array
     */
    protected $_layoutPaths = [];

    /**
     * @var string
     */
    protected $_layout;

    /**
     * @var string
     */
    protected $_separator = '.';

    /**
     * Render layout file.
     * @param string $layout
     * @param array $args
     * @return null|string
     */
    public function render($layout, array $args = [])
    {
        if ($_layout = $this->_getLayoutPath($layout)) {
            extract($args);
            ob_start();
            /** @noinspection PhpIncludeInspection */
            include($_layout);
            $output = ob_get_contents();
            ob_end_clean();
            return $output;
        }

        return null;
    }

    /**
     * Add layout paths to renderer.
     * @param string|array $paths
     * @return $this
     * @throws \JBZoo\Path\Exception
     */
    public function addPath($paths)
    {
        $paths = (array) $paths;
        foreach ($paths as $path) {
            $path = FS::clean($path . '/');
            $this->app['path']->set(self::PATH_ALIAS, $path . $this->_folder);
        }

        return $this;
    }

    /**
     * @param string $layout
     * @return string
     */
    protected function _getLayoutPath($layout)
    {
        if (!Arr::key($layout, $this->_layoutPaths)) {
            $details  = explode($this->_separator, $layout);
            $fullPath = Str::low(implode('/', $details)) . $this->_ext;
            $this->_layout = preg_replace('/[^A-Z0-9_\.-]/i', '', Str::low(end($details)));
            $this->_setLayoutPath($layout, $fullPath);
        }

        return $this->_layoutPaths[$layout];
    }

    /**
     * @param string $layout
     * @param string $path
     * @return void
     */
    protected function _setLayoutPath($layout, $path)
    {
        $this->_layoutPaths[$layout] = $this->app['path']->get(self::PATH_ALIAS . ':' . FS::clean($path, '/'));
    }
}
