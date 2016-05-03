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

use JBZoo\CCK\Atom\AdminController;

/**
 * Class Index
 * @package JBZoo\CCK
 */
class AdminIndex extends AdminController
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
            'state'   => $this->app['core.env']->getState(),
            'sidebar' => $this->app['core.env']->getSidebar(),
            'defines' => $this->app['core.env']->getInitDefines()
        ], true);

        ?>
        <div id="jbzoo-app" class="jbzoo">
            Loading...
        </div>
        <?php
    }
}
