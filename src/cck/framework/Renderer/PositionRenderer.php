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

use JBZoo\Data\JSON;
use JBZoo\Utils\Arr;

/**
 * Class PositionRenderer
 * @package JBZoo\CCK\Renderer
 */
abstract class PositionRenderer extends Renderer
{

    const CONFIG_KEY = 'render';

    const STYLES_FOLDER = 'position-styles';

    const DEFAULT_STYLE = 'default';

    /**
     * @var JSON
     */
    protected $_config;

    /**
     * @var string
     */
    protected $_positionManifest = 'positions.manifest.php';

    /**
     * Get position config.
     * @param string $layout
     * @return JSON
     */
    public function getConfig($layout)
    {
        if (!count($this->_config)) {
            $this->_config = jbdata($this->app['cfg']->find(self::CONFIG_KEY . '.' . $layout, []));
        }

        return $this->_config;
    }

    /**
     * Get positions for layout.
     * @param string $layout
     * @return \JBZoo\Data\Data
     */
    public function getPositions($layout)
    {
        $positions = [];
        $parts     = explode('.', $layout);
        $layout    = array_pop($parts);
        $path      = implode('/', $parts);
        $path      = $path . '/' . $this->_positionManifest;
        $fullPath  = $this->app['path']->get($this->_pathAlias . ':' . $path);

        if ($fullPath !== null) {
            /** @noinspection PhpIncludeInspection */
            $_positions = include($fullPath);

            if (Arr::key($layout, $_positions)) {
                $positions['name'] = $layout;
                $positions['positions'] = $_positions[$layout];
            }
        }

        return jbdata($positions);
    }

    /**
     * Check if a position generates some output.
     * @param string $position
     * @return bool
     */
    abstract public function checkPosition($position);

    /**
     * Render the output of the position.
     * @param string $position
     * @param array $options
     * @return string
     */
    abstract public function renderPosition($position, array $options = []);
}
