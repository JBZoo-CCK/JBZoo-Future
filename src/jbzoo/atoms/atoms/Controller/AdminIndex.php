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

namespace JBZoo\CCK\Atom\Atoms\Controller;

use JBZoo\CCK\Atom\AdminController;
use JBZoo\Data\PHPArray;

/**
 * Class AdminIndex
 * @package JBZoo\CCK
 */
class AdminIndex extends AdminController
{
    /**
     * Index action
     */
    public function getConfigForms()
    {
        $atomList = $this->app['atoms']->loadInfo('*');

        $configs = [];

        /** @var PHPArray $atomInfo */
        foreach ($atomList as $atomId => $atomInfo) {
            $atomInfo->remove('init');
            $atomInfo->remove('dir');

            if ($atomInfo->get('config') && $atomInfo->find('meta.name')) {
                $configs[$atomId] = $atomInfo->getArrayCopy();
            }
        }

        $this->_json(['list' => $configs]);
    }

    public function saveOption()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        list($atomId, $path) = explode('.', $data['name'], 2);

        $subpath = false;
        if (strpos($path, '.')) {
            list($path, $subpath) = explode('.', $path, 2);
        }

        $this->app['atoms']['core']['config']->set('atom.' . $atomId, [
            $path => $subpath ? [$subpath => $data['value']] : $data['value']
        ]);

        $this->_json();
    }
}
