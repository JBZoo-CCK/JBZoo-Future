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

use JBZoo\Utils\Url;

/**
 * Class FrontpageTest
 * @package JBZoo\PHPUnit
 */
class FrontpageTest extends JBZooPHPUnit
{

    public function testLoadIndex()
    {
        $uniqid = uniqid('uniqid-');
        $type   = $this->app['type'];

        $content = $this->helper->runIsolated(function () use ($type, $uniqid) {
            if ($type != 'Joomla') {
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

    public function testError404()
    {
        $result = $this->_request('test.index.error404');

        var_dump($result);

        isContain("Some 404 error message", $result->get('body'));

        if ($this->app['type'] == 'Joomla') {
            isSame(404, $result->get('code'));
        } else {
            skip('TODO: Wordpress, fix http 404 code');
        }

    }

    public function testError500()
    {
        $result = $this->_request('test.index.error500');

        isContain("Some 500 error message", $result->get('body'));

        if ($this->app['type'] == 'Joomla') {
            isSame(500, $result->get('code'));
        } else {
            skip('TODO: Wordpress, fix http 500 code');
        }

    }
}
