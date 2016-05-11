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

namespace JBZoo\CCK\Atom\Test\Controller;

use JBZoo\CCK\Atom\SiteController;

/**
 * Class SiteIndex
 * @package JBZoo\CCK
 */
class SiteIndex extends SiteController
{
    /**
     * Check that action return some value (not echo!)
     */
    public function checkReturn()
    {
        return 123456;
    }

    /**
     * Show uniq var from request
     */
    public function index()
    {
        echo $this->app['request']->get('uniqid');
    }

    /**
     * Add JS variable to document
     */
    public function addDocumentVariable()
    {
        $this->app['core.js']->addVar('SomeVar', 42);
    }
}
