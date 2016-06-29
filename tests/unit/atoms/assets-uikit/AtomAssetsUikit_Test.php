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
 * Class AtomAssetsUikit_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssetsUikit_Test extends JBZooPHPUnit
{
    public function testUIkit()
    {
        $result = $this->helper->request('test.index.assetsUIkit');
        isContain("/jquery.js", $result->get('body'));
        isContain("uikit.min.js", $result->get('body'));
        isContain("uikit.min.css", $result->get('body'));
    }
}
