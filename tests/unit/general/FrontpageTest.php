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
 * Class FrontpageTest
 * @package JBZoo\PHPUnit
 */
class FrontpageTest extends JBZooPHPUnit
{

    public function testLoadIndex()
    {
        $uniqid = uniqid('uniqid-');

        $content = $this->helper->runIsolated(function () {
        }, [
            'method' => 'post',
            'get'    => [
                'option' => 'com_jbzoo',
                'page'   => 'jbzoo',
                'uniqid' => $uniqid,
                'act'    => 'test.index.index'
            ]
        ]);

        isContain($uniqid, $content);
        isNotContain("window.JBZooVars = {};", $content);
    }

    public function testAddDocumentVariable()
    {
        if ($this->app['type'] == 'Joomla') {

            $content = $this->helper->runIsolated(function () {
            }, [
                'method' => 'post',
                'get'    => [
                    'option' => 'com_jbzoo',
                    'page'   => 'jbzoo',
                    'act'    => 'test.index.AddDocumentVariable'
                ]
            ]);

            isContain("window.JBZooVars = {};", $content);
            isContain("window.JBZooVars['SomeVar'] = 42;", $content);

        } else {
            skip();
        }
    }
}