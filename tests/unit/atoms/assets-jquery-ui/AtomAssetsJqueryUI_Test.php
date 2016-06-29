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
 * Class AtomAssetsJqueryUi_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssetsJqueryUi_Test extends JBZooPHPUnit
{
    public function testJQueryUI()
    {
        $result = $this->helper->request('test.index.assetsJQueryUI');

        if (__CMS__ == 'joomla') {
            isContain("jquery.ui.", $result->get('body'));
        } else {
            isContain("jquery/ui/core", $result->get('body'));
        }
    }
}
