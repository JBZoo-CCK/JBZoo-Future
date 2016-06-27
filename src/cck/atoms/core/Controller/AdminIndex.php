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

use JBZoo\CCK\Controller\Admin;

/**
 * Class Index
 * @package JBZoo\CCK
 */
class AdminIndex extends Admin
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

        $this->app['core.js']->addVar('JBZOO_INIT', [
            'state'   => $this->app['core.state']->getState(),
            'sidebar' => $this->app['core.state']->getSidebar(),
            'defines' => $this->app['core.state']->getInitDefines()
        ], true);

        ?>
        <div id="jbzoo-app" class="jbzoo">
            Loading...
        </div>
        <?php
    }
}
