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
use JBZoo\CCK\Exception;
use JBZoo\Utils\Str;

/**
 * Class Debug
 * @package JBZoo\CCK
 * @codeCoverageIgnore
 */
class Installer extends Helper
{
    /**
     * Script to install component
     */
    public function install()
    {
        $queries = $this->_getQueries('install.sql');

        foreach ($queries as $query) {
            if ($this->app['db']->query($query) === false) {
                throw new \RuntimeException('Unable to create JBZoo tables.');
            }
        }
    }

    /**
     * Script to uninstall component
     */
    public function uninstall()
    {
        $queries = $this->_getQueries('unstall.sql');

        foreach ($queries as $query) {
            if ($this->app['db']->query($query) === false) {
                throw new \RuntimeException('Unable to remove JBZoo tables.');
            }
        }
    }

    /**
     * Script to update component
     */
    public function update()
    {
    }

    /**
     * Script before install component
     */
    public function preflight()
    {
    }

    /**
     * Script after install component
     */
    public function postflight()
    {
    }

    /**
     * Open and split SQL file
     *
     * @param $filename
     * @return array
     * @throws Exception
     */
    protected function _getQueries($filename)
    {
        $path = $this->app['path']->get("install:$filename");

        if (file_exists($path)) {
            $queries = file_get_contents($path);
            $queries = Str::splitSql($queries);

            return (array)$queries;
        }

        throw new Exception("SQL file {$path} not found!");
    }
}
