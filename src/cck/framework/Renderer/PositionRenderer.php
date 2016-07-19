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
use JBZoo\CCK\Table\Position;

/**
 * Class PositionRenderer
 * @package JBZoo\CCK\Renderer
 */
abstract class PositionRenderer extends Renderer
{

    const CONFIG_KEY = 'render';

    /**
     * @var JSON
     */
    protected $_config;

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
}
