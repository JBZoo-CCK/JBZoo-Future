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
 * Class UnitHelperTest
 * @package JBZoo\PHPUnit
 */
class UnitHelperTest extends JBZooPHPUnit
{
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
