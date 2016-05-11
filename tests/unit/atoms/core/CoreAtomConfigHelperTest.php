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
 * Class CoreAtomConfigHelperTest
 * @package JBZoo\PHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class CoreAtomConfigHelperTest extends JBZooPHPUnit
{
    /**
     * @return Config
     */
    protected function _getCfg()
    {
        return $this->app['core.config'];
    }

    public function testGetUndefined()
    {
        $cfg = $this->_getCfg();

        isNull($cfg->get('undefined_1'));
        isNull($cfg->find('undefined_2'));

        isSame(42, $cfg->get('undefined_3', 42));
        isSame('42', $cfg->get('undefined_4', ' 42 ', 'trim'));
    }

    public function testGetUndefinedNested()
    {
        $cfg = $this->_getCfg();

        isNull($cfg->get('undefined.undefined'));
        isNull($cfg->find('undefined.undefined'));

        isSame(42, $cfg->get('undefined_3.undefined', 42));
        isSame('42', $cfg->get('undefined_4.undefined', ' 42 ', 'trim'));
    }

    public function testSetAndGetString()
    {
        $cfg = $this->_getCfg();

        $uniq = uniqid('string-');
        $cfg->set('qwerty.string', $uniq);
        isSame($uniq, $cfg->get('qwerty.string'));
    }

    public function testSetAndGetInt()
    {
        $cfg = $this->_getCfg();

        $uniq = rand(10, 1000000);
        $cfg->set('qwerty.int', $uniq);
        isSame($uniq, $cfg->get('qwerty.int'));
    }

    public function testSetAndGetFloat()
    {
        $cfg = $this->_getCfg();

        $uniq = rand(11, 189) / rand(11, 145);
        $cfg->set('qwerty.float', $uniq);
        isSame($uniq, $cfg->get('qwerty.float'));
    }

    public function testSetAndGetBool()
    {
        $cfg = $this->_getCfg();

        $cfg->set('qwerty.bool.true', true);
        isSame(true, $cfg->get('qwerty.bool.true'));

        $cfg->set('qwerty.bool.false', false);
        isSame(false, $cfg->get('qwerty.bool.false'));
    }

    public function testSetAndGetArray()
    {
        $cfg = $this->_getCfg();

        $cfg->set('qwerty.array', [1, 2, 3]);
        isSame([1, 2, 3], (array)$cfg->get('qwerty.array'));
    }

    public function testSetAndGetAssoc()
    {
        $cfg  = $this->_getCfg();
        $data = ['key' => 'value'];

        $cfg->set('qwerty.assoc', $data);
        isSame($data, (array)$cfg->get('qwerty.assoc'));
    }

    public function testSetAndGetData()
    {
        $cfg  = $this->_getCfg();
        $data = jbdata(['key' => 'value']);

        $cfg->set('qwerty.data', $data);
        isClass('\JBZoo\Data\Data', $cfg->get('qwerty.data'));
        isSame((array)$data, $cfg->get('qwerty.data', [], 'arr'));
        isClass('\JBZoo\Data\Data', $cfg->get('qwerty.data', [], 'data'));
    }

    public function testMerge()
    {
        $cfg   = $this->_getCfg();
        $uniq1 = uniqid('u1-', true);
        $uniq2 = uniqid('u1-', true);

        // Clean up
        $cfg->set('qwerty.merge', [], false);
        isSame([], (array)$cfg->get('qwerty.merge'));


        $cfg->set('qwerty.merge', ['key_1' => $uniq1]);
        isSame(['key_1' => $uniq1], (array)$cfg->get('qwerty.merge'));


        $cfg->set('qwerty.merge', ['key_2' => $uniq2]);
        isSame(['key_1' => $uniq1, 'key_2' => $uniq2], (array)$cfg->get('qwerty.merge'));


        $cfg->set('qwerty.merge', []);
        isSame(['key_1' => $uniq1, 'key_2' => $uniq2], (array)$cfg->get('qwerty.merge'));
    }

}
