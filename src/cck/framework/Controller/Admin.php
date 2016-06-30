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

namespace JBZoo\CCK\Controller;

use JBZoo\CCK\Exception;

/**
 * Class Admin
 * @package JBZoo\CCK
 */
class Admin extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $user = $this->app['user']->getCurrent();
        if (!$user || !$user->isAdmin()) {
            throw new Exception('You should be admin!');
        }
    }
}
