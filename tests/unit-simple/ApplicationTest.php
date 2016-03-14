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

use JBZoo\CCK\App;

/**
 * Class ApplicationTest
 * @package JBZoo\PHPUnit
 */
class ApplicationTest extends JBZooPHPUnit
{
    public function testInstance()
    {
        isClass('\JBZoo\CCK\App', App::getInstance());
    }

    public function testIsolatedRender()
    {
        $uniq = uniqid('somestring');

        $content = $this->helper->runIsolated(
            'test',
            function () use ($uniq) {
                echo $_POST['rand'];
                \JBZoo\PHPunit\isSame($_POST['rand'], $uniq);
            },
            [
                'rand' => $uniq,
            ],
            '/',
            'POST'
        );

        //echo $content;

        isContain($uniq, $content);
    }
}
