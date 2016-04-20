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

        $this->app['core.js']->addVar('JBZOO_INITIAL_STATE', [
            'routes'  => $this->app['route']->loadAllAtoms(),
            'sidebar' => [
                ['path' => 'atoms', 'name' => 'Atoms'],
                ['path' => 'modules', 'name' => 'Modules'],
                ['path' => 'config', 'name' => 'Configuration']
            ],
            'defines' => [
                'AJAX_URL' => JBZOO_AJAX_URL,
                '__DEV__'  => $this->app['config']->isDebug()
            ]
        ], true);

        ?>
        <div id="jbzoo-react-app" class="jbzoo">
            Loading...
        </div>
        <?php
    }
}
