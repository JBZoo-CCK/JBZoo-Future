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
 * Class AtomAssets_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssets_Test extends JBZooPHPUnit
{
    public function testPlainCssCode()
    {
        $result = $this->helper->request('test.index.assetsPlainCssCode');
        isContain("div { display: none; }", $result->get('body'));
    }

    public function testPlainJsxCode()
    {
        $result = $this->helper->request('test.index.assetsPlainJsxCode');
        isContain('<script type="text/babel">Some code for Reactjs</script>', $result->get('body'));
    }

    public function testIngnoreOnAjax()
    {
        $result = $this->helper->request('test.index.assetsIgnoreAjaxRequest');
        isNotContain("jbzoo-jquery-factory.min.js", $result->get('body'));
    }
}
