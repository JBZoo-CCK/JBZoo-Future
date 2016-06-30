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
use JBZoo\CCK\Entity\Item;

/**
 * Class SiteElement
 * @package JBZoo\CCK\Atom\Test\Controller
 */
class SiteElement extends Site
{
    public function checkLoadAssets()
    {
        /** @var Item $item */
        $item = $this->app['models']['item']->get(1);

        $element = $item->getElement('some-test');

        echo $element->render(jbdata(['layout' => 'load-assets']));
    }
}
