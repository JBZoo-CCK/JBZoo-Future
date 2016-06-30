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

use JBZoo\CCK\Atom\Core\Helper\Config;

/**
 * Class AtomCore_HelperConfigTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class AtomCore_HelperConfigTest extends JBZooPHPUnit
{
    /**
     * @return Config
     */
    protected function _getCfg()
    {
        return $this->app['atoms']['core']['config'];
    }

    public function testGetUndefined()
    {
        $cfg = $this->_getCfg();

        skip('Fix config helper');

        //isNull($cfg->get('undefined_1'));
        isNull($cfg->find('undefined_2'));

        isSame(42, $cfg->find('undefined_3', 42));
        isSame('42', $cfg->find('undefined_4', ' 42 ', 'trim'));
    }

    public function testGetUndefinedNested()
    {
        $cfg = $this->_getCfg();

        skip('Fix config helper');

        //isNull($cfg->get('undefined.undefined'));
        isNull($cfg->find('undefined.undefined'));

        isSame(42, $cfg->find('undefined_3.undefined', 42));
        isSame('42', $cfg->find('undefined_4.undefined', ' 42 ', 'trim'));
    }

    public function testSetAndGetString()
    {
        $cfg = $this->_getCfg();

        $uniq = uniqid('string-');
        $cfg->set('phpunit.string', $uniq);
        isSame($uniq, $cfg->find('phpunit.string'));
    }

    public function testSetAndGetInt()
    {
        $cfg = $this->_getCfg();

        $uniq = rand(10, 1000000);
        $cfg->set('phpunit.int', $uniq);
        isSame($uniq, $cfg->find('phpunit.int'));
    }

    public function testSetAndGetFloat()
    {
        $cfg = $this->_getCfg();

        $uniq = rand(11, 189) / rand(11, 145);
        $cfg->set('phpunit.float', $uniq);
        isSame($uniq, $cfg->find('phpunit.float'));
    }

    public function testSetAndGetBool()
    {
        $cfg = $this->_getCfg();

        $cfg->set('phpunit.bool.true', true);
        isSame(true, $cfg->find('phpunit.bool.true'));

        $cfg->set('phpunit.bool.false', false);
        isSame(false, $cfg->find('phpunit.bool.false'));
    }

    public function testSetAndGetArray()
    {
        $cfg = $this->_getCfg();

        $cfg->set('phpunit.array', [1, 2, 3]);
        isSame([1, 2, 3], (array)$cfg->find('phpunit.array'));
    }

    public function testSetAndGetAssoc()
    {
        $cfg  = $this->_getCfg();
        $data = ['key' => 'value'];

        $cfg->set('phpunit.assoc', $data);
        isSame($data, (array)$cfg->find('phpunit.assoc'));
    }

    public function testSetAndGetData()
    {
        $cfg  = $this->_getCfg();
        $data = jbdata(['key' => 'value']);

        $cfg->set('phpunit.data', $data);
        isClass('\JBZoo\Data\Data', $cfg->find('phpunit.data'));
        isSame((array)$data, $cfg->find('phpunit.data', [], 'arr'));
        isClass('\JBZoo\Data\Data', $cfg->find('phpunit.data', [], 'data'));
    }

    public function testMerge()
    {
        $cfg   = $this->_getCfg();
        $uniq1 = uniqid('u1-', true);
        $uniq2 = uniqid('u2-', true);

        // Clean up
        $cfg->set('phpunit.merge', [], false);
        isSame([], (array)$cfg->find('phpunit.merge'));


        $cfg->set('phpunit.merge', ['key_1' => $uniq1]);
        isSame(['key_1' => $uniq1], (array)$cfg->find('phpunit.merge'));


        $cfg->set('phpunit.merge', ['key_2' => $uniq2]);
        isSame(['key_1' => $uniq1, 'key_2' => $uniq2], (array)$cfg->find('phpunit.merge'));


        $cfg->set('phpunit.merge', []);
        isSame(['key_1' => $uniq1, 'key_2' => $uniq2], (array)$cfg->find('phpunit.merge'));
    }

    public function testMergeNested()
    {
        $cfg   = $this->_getCfg();
        $uniq1 = uniqid('u1-', true);
        $uniq2 = uniqid('u2-', true);

        // Clean up
        $cfg->set('phpunit.merge.nested', [], false);
        isSame([], (array)$cfg->find('phpunit.merge.nested'));

        $data = [
            'key' => $uniq1,
            'nst' => [
                'key' => $uniq2,
            ],
        ];
        $cfg->set('phpunit.merge.nested', $data);
        isSame($data, (array)$cfg->find('phpunit.merge.nested'));

        $cfg->set('phpunit.merge.nested', ['key' => 1]);
        $data['key'] = 1;
        isSame($data, (array)$cfg->find('phpunit.merge.nested'));


        $cfg->set('phpunit.merge.nested', ['nst' => ['other' => 3]]);
        $data['nst']['other'] = 3;
        isSame($data, (array)$cfg->find('phpunit.merge.nested'));
    }

}
