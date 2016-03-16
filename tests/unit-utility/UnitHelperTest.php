<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

namespace JBZoo\PHPUnit;

/**
 * Class UnitTest
 * @package JBZoo\PHPUnit
 */
class UnitTest extends JBZooPHPUnit
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
