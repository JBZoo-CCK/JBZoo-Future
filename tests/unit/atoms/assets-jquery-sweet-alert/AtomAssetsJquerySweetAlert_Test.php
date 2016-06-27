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
 * Class AtomAssetsJquerySweetAlert_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssetsJquerySweetAlert_Test extends JBZooPHPUnit
{
    public function testJQuerySweetAlert()
    {
        $result = $this->_request('test.index.assetsJQuerySweetAlert');
        isContain("/jquery.js", $result->get('body'));
        isContain("/sweetalert.min.js", $result->get('body'));
        isContain("/sweetalert.min.css", $result->get('body'));
    }
}
