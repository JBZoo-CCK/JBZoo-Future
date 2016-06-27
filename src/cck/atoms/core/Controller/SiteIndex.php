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

use JBZoo\CCK\Controller\Site;

/**
 * Class Index
 * @package JBZoo\CCK
 */
class SiteIndex extends Site
{
    /**
     * Index action
     */
    public function index()
    {
        ?>
        JBZoo CCK
        <?php
    }
}
