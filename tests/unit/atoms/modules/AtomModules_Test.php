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

use JBZoo\CCK\Atom\Modules\Entity\Module;

/**
 * Class AtomModules_Test
 */
class AtomModules_Test extends JBZooPHPUnit
{

    public function testIndexAction()
    {
        $response = $this->helper->requestAdmin('modules.index.index');
        isTrue(is_array($response->find('list')));
    }

    public function testAddAction()
    {
        $uniqName = uniqid('name-');

        $request = [
            'module' => [
                'title' => $uniqName,
                'params' => 'test-params',
            ]
        ];

        $response = $this->helper->requestAdmin('modules.index.add', $request, 'PAYLOAD');

        /** @var Module $newModule */
        $newModule = $this->app['models']['module']->get($response->find('module.id'));
        isSame($uniqName, $response->find('module.title'));
        isSame($uniqName, $newModule->title);
    }

    public function testUpdateAction()
    {
        $uniqName = uniqid('name-');
        $request = [
            'module' => [
                'id' => 2,
                'title' => $uniqName,
                'params' => 'custom-params',
            ]
        ];

        $response = $this->helper->requestAdmin('modules.index.update', $request, 'PAYLOAD');
        /** @var Module $module */
        $module = $this->app['models']['module']->get($response->find('module.id'));
        isSame($uniqName, $module->title);
        isSame('2', $module->id);
    }

    public function testRemoveModuleAction()
    {
        $response = $this->helper->requestAdmin('modules.index.add', ['module' => []], 'PAYLOAD');

        $newId = $response->find('module.id');
        isTrue($newId > 0);

        /** @var Module $newModule */
        $newModule = $this->app['models']['module']->get($newId);
        isTrue($newModule);

        // Check remove new module
        $response = $this->helper->requestAdmin('modules.index.remove', ['id' => $newId], 'PAYLOAD');
        is($newId, $response->find('removed'));

        $this->app['models']['module']->cleanObjects();
        $newItem = $this->app['models']['module']->get($newId);
        isFalse($newItem);

        $response = $this->helper->requestAdmin('modules.index.remove', ['id' => 100500], 'PAYLOAD');
        is(0, $response->find('removed'));
    }
}
