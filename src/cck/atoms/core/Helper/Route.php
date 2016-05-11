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

use JBZoo\CCK\Atom\Helper;

/**
 * Class Route
 * @package JBZoo\CCK
 */
class Route extends Helper
{
    /**
     * @return array
     */
    public function loadAllAtoms()
    {
        $manifests = $this->app['path']->glob('atoms:*/atom.routes.php');

        $allRoutes = [];

        foreach ($manifests as $manifest) {
            $routes = include $manifest;
            $allRoutes += $routes;
        }

        return $allRoutes;
    }
}
