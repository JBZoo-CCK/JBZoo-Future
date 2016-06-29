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
 * Class AtomAssetsBabel_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssetsBabel_Test extends JBZooPHPUnit
{
    public function testBabel()
    {
        $result = $this->helper->request('test.index.assetsBabel');
        isContain("babel-core", $result->get('body'));
    }
}
