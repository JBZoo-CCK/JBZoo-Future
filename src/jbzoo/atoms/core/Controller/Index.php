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

namespace JBZoo\CCK\Atom\Core\Controller;

use JBZoo\Assets\Asset\Asset;
use JBZoo\CCK\Atom\Controller;

/**
 * Class Index
 * @package JBZoo\CCK
 */
class Index extends Controller
{
    /**
     * Index action
     */
    public function index()
    {
        $this->app['assets']->add('my', [
            'atom-core:assets/js/core.min.js',
            'assets:less/admin.less',
        ]);

        $routes = $this->app['route']->loadAllAtoms();

        $this->app['assets']->add(
            'routes',
            'window.JBZooRoutes = ' . json_encode($routes) . '; ',
            [],
            ['type' => Asset::TYPE_JS_CODE]
        );

        ?>
        <div id="jbzoo-react-app" class="jbzoo">
            Loading...
        </div>
        <?php
    }
}
