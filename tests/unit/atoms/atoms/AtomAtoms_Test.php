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
 * Class AtomAtoms_Test
 */
class AtomAtoms_Test extends JBZooPHPUnit
{
    protected $_fixtureFile = 'AtomAtoms_Test.php';

    public function testGetConfigFormsAction()
    {
        $response = $this->helper->requestAdmin('atoms.index.getConfigForms');

        isTrue(is_array($response->find('list')));
    }

    public function testSaveOptionActionSimple()
    {
        $unique = uniqid('value-');

        $response = $this->helper->requestAdmin('atoms.index.saveOption', [
            'name'  => 'test.checkbox',
            'value' => $unique,
        ], 'PAYLOAD');

        isSame([], $response->getArrayCopy());

        $this->app['cfg']->cleanCache();
        isSame($unique, $this->app['cfg']->find('atom.test')->find('checkbox'));
    }

    public function testSaveOptionActionGrouped()
    {
        $unique = uniqid('value-');

        $response = $this->helper->requestAdmin('atoms.index.saveOption', [
            'name'  => 'test.group.toggle',
            'value' => $unique,
        ], 'PAYLOAD');

        isSame([], $response->getArrayCopy());

        $this->app['cfg']->cleanCache();
        isSame($unique, $this->app['cfg']->find('atom.test')->find('group.toggle'));
    }
}
