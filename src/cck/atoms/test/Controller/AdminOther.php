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

use JBZoo\CCK\Controller\Site;

/**
 * Class AdminOther
 * @package JBZoo\CCK
 */
class AdminOther extends Site
{
    public function testRequestAdmin()
    {
        $variable = $this->app['request']->get('some-var');
        $this->_json(['variable' => $variable]);
    }
}
