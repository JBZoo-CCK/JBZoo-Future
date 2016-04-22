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

namespace JBZoo\CCK\Atom\Atoms\Controller;

use JBZoo\CCK\Atom\AdminController;
use JBZoo\Data\PHPArray;

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

        $atomList = $this->app['atoms']->loadInfo('*');

        $configs = [];

        /** @var PHPArray $atomInfo */
        foreach ($atomList as $atomId => $atomInfo) {
            if ($configRow = $atomInfo->get('config')) {
                $configs[$atomId] = $configRow;
            }
        }

        $this->app['response']->json(['list' => $configs]);
    }
}
