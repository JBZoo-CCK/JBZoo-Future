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

namespace JBZoo\PHPUnit;

/**
 * Class Framework_PositionRendererTest
 * @package JBZoo\PHPUnit
 */
class Framework_PositionRendererTest extends JBZooPHPUnit
{

    public function testGetConfig()
    {
        $renderer = $this->app['renderer'];
        $renderer->add('items', 'item');

        /** @var \JBZoo\CCK\Atom\Items\Renderer\ItemRenderer $itemRenderer */
        $itemRenderer = $renderer['item'];
        isClass('JBZoo\CCK\Atom\Items\Renderer\ItemRenderer', $itemRenderer);

        $config = $itemRenderer->getConfig('product-type.full');
        isClass('JBZoo\Data\JSON', $config);
    }
}
