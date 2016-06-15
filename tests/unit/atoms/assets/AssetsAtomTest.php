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
 * Class AssetsAtomTest.php
 * @package JBZoo\PHPUnit
 */
class AssetsAtomTest extends JBZooPHPUnit
{

    public function testJQuery()
    {
        $result = $this->_request('test.index.assetsJQuery');
        isContain("/jquery.js", $result->get('body'));
    }

    public function testJQueryUI()
    {
        $result = $this->_request('test.index.assetsJQueryUI');

        if (__CMS__ == 'joomla') {
            isContain("jquery.ui.", $result->get('body'));
        } else {
            isContain("jquery/ui/core", $result->get('body'));
        }
    }

    public function testJQueryBrowser()
    {
        $result = $this->_request('test.index.assetsJQueryBrowser');
        isContain("/jquery.js", $result->get('body'));
        isContain("/jquery.browser.min.js", $result->get('body'));
    }

    public function testJQueryCookie()
    {
        $result = $this->_request('test.index.assetsJQueryCookie');
        isContain("/jquery.js", $result->get('body'));
        isContain("/jquery.cookie.min.js", $result->get('body'));
    }

    public function testBabel()
    {
        $result = $this->_request('test.index.assetsBabel');
        isContain("babel-core", $result->get('body'));
    }

    public function testBootstrap()
    {
        $result = $this->_request('test.index.assetsBootstrap');
        isContain("/jquery.js", $result->get('body'));
        isContain("bootstrap.min.js", $result->get('body'));
        isContain("bootstrap.min.css", $result->get('body'));
    }

    public function testJBZooUtils()
    {
        $result = $this->_request('test.index.assetsJBZooUtils');
        isContain("jbzoo-utils.min.js", $result->get('body'));
    }

    public function testMaterialize()
    {
        $result = $this->_request('test.index.assetsMaterialize');
        isContain("materialize.min.css", $result->get('body'));
        isContain("materialize.min.js", $result->get('body'));
        isContain("family=Material+Icons", $result->get('body'));
        isContain("/jquery.js", $result->get('body'));
    }

    public function testReact()
    {
        $result = $this->_request('test.index.assetsReact');
        isContain("react.min.js", $result->get('body'));
    }

    public function testUIkit()
    {
        $result = $this->_request('test.index.assetsUIkit');
        isContain("uikit.min.js", $result->get('body'));
        isContain("uikit.min.css", $result->get('body'));
    }

}
