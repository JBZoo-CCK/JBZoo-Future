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

use JBZoo\CCK\App;

/**
 * Class Framework_RenderPageTest
 * @package JBZoo\PHPUnit
 */
class Framework_RenderPageTest extends JBZooPHPUnit
{
    public function testRenderJson()
    {
        $actual = ['foo' => 'bar'];

        $result = $this->helper->request('test.index.renderJson', [
            'test-data' => $actual
        ]);

        $expected = json_decode($result->get('body'), true);

        isSame(200, $result->get('code'));
        isSame('application/json; charset=utf-8', $result->find('headers.content-type'));
        isSame($expected, $actual);
    }

    public function testError404()
    {
        $result = $this->helper->request('test.index.error404');
        isSame(404, $result->get('code'));
        isContain("Some 404 error message", $result->get('body'));
    }

    public function testError500()
    {
        $result = $this->helper->request('test.index.error500');
        isSame(500, $result->get('code'));
        isContain("Some 500 error message", $result->get('body'));
    }

    public function testLoadIndex()
    {
        $uniqid = uniqid('uniqid-');
        $type   = $this->app['type'];

        $content = $this->helper->runIsolated(function () use ($type, $uniqid) {
            if ($type != App::TYPE_JOOMLA) {
                echo $uniqid;
            }
        }, [
            'method' => 'post',
            'get'    => [
                'option' => 'com_jbzoo',
                'p'      => WP_POST_ID,
                'uniqid' => $uniqid,
                'act'    => 'test.index.index'
            ]
        ]);

        isContain($uniqid, $content);
        isNotContain("window.JBZooVars = {};", $content);
    }

    public function testAddDocumentVariable()
    {
        $content = $this->helper->runIsolated(function () {
        }, [
            'method' => 'post',
            'get'    => [
                'option' => 'com_jbzoo',
                'p'      => WP_POST_ID,
                'act'    => 'test.index.AddDocumentVariable'
            ]
        ]);

        isContain("window.JBZooVars = {};", $content);
        isContain("window.JBZooVars['SomeVar'] = 42;", $content);
    }
}
