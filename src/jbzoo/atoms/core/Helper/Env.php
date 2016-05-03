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

namespace JBZoo\CCK\Atom\Core\Helper;

use JBZoo\CCK\Atom\Helper;
use JBZoo\Data\PHPArray;

/**
 * Class Env
 * @package JBZoo\CCK
 */
class Env extends Helper
{
    /**
     * @return array
     */
    public function getInitDefines()
    {
        return [
            'AJAX_URL' => JBZOO_AJAX_URL,
            '__DEV__'  => $this->app['config']->isDebug()
        ];
    }

    /**
     * @return array
     */
    public function getSidebar()
    {
        return [
            ['path' => 'atoms', 'name' => 'Atoms'],
            ['path' => 'modules', 'name' => 'Modules'],
            ['path' => 'config', 'name' => 'Configuration']
        ];
    }

    /**
     * @return \stdClass
     */
    public function getState()
    {
        $state = [];

        // get configs
        $atomList = $this->app['atoms']->loadInfo('*');
        $configs  = [];

        /** @var PHPArray $atomInfo */
        foreach ($atomList as $atomId => $atomInfo) {
            $atomInfo->remove('init');
            $atomInfo->remove('dir');

            if ($atomCfg = $atomInfo->get('config')) {
                foreach ($atomCfg as $name => $field) {
                    if ($field['type'] == 'group') {
                        foreach ($field['childs'] as $childName => $childField) {
                            $configs[$atomId][$name][$childName] = $childField['default'];
                        }
                    } else {
                        $configs[$atomId][$name] = isset($field['default']) ? $field['default'] : null;
                    }
                }
            }
        }

        $state['config'] = $configs;

        return $state;
    }
}
