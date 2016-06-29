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
 * Class Utility_UnitHelperTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Utility_UnitHelperTest extends JBZooPHPUnit
{
    public function testRequestAdminBatch()
    {
        $number = mt_rand(10, 10000);
        $shift  = mt_rand(10, 10000);

        $json = $this->helper->requestAdminBatch([
            ['test.other.testRequestBatch1', ['number' => $number, 'shift' => $shift], 'PAYLOAD'],
            ['test.other.testRequestBatch2', ['number' => $number, 'shift' => $shift], 'GET'],
            ['test.other.testRequestBatch3', ['number' => $number, 'shift' => $shift], 'POST'],
        ]);

        is($number + $shift, $json[0]->find('result'));
        is($number + $shift, $json[1]->find('result'));
        is($number + $shift, $json[2]->find('result'));
    }

    public function testRequestAdmin()
    {
        $uniqId = uniqid('some-var-', true);
        $json   = $this->helper->requestAdmin('test.other.testRequestAdmin', ['some-var' => $uniqId]);
        isSame($uniqId, $json->get('variable'));

        $htmlContent = $this->helper->requestAdmin('core.index.index', [], 'GET', false);

        isContain('assets/js/assets-common.min.js', $htmlContent->body);
        isContain('assets/js/core.min.js', $htmlContent->body);
        isContain('<div id="jbzoo-app" class="jbzoo">', $htmlContent->body);
    }

    public function testRequest()
    {
        $uniqId = uniqid('some-var-', true);
        $json   = $this->helper->request('test.other.testRequest', ['some-var' => $uniqId], '/', true);
        isSame($uniqId, $json->get('variable'));
    }

    public function testIsolatedRender()
    {
        $uniq = uniqid('somestring');

        $content = $this->helper->runIsolated(
            function () use ($uniq) {
                \JBZoo\PHPunit\isSame($_GET['rand'], $uniq);
                \JBZoo\PHPunit\isSame($_POST['rand'], $uniq);
                \JBZoo\PHPunit\isSame($_COOKIE['rand'], $uniq);
                \JBZoo\PHPunit\isSame($_REQUEST['rand'], $uniq);
                \JBZoo\PHPunit\isSame($_REQUEST['jbzoo-phpunit'], '1');

                \JBZoo\PHPunit\isSame('POST', $_SERVER['REQUEST_METHOD']);

                $url = \JBZoo\Utils\Url::addArg(['rand' => $uniq], '/index.php');
                \JBZoo\PHPunit\isSame($url, $_SERVER['REQUEST_URI']);

                echo $uniq;
            },
            [
                'path'   => '/index.php',
                'method' => 'post',
                'post'   => [
                    'rand' => $uniq,
                ],
                'get'    => [
                    'rand' => $uniq,
                ],
                'cookie' => [
                    'rand' => $uniq,
                ],
            ]
        );

        isContain($uniq, $content);
    }
}
