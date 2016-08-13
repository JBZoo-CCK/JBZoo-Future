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
}
