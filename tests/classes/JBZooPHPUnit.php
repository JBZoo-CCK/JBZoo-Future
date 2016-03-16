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
use JBZoo\PimpleDumper\PimpleDumper;

/**
 * Class CrossCMS
 * @package JBZoo\PHPUnit
 */
abstract class JBZooPHPUnit extends PHPUnit
{
    /**
     * @var App
     */
    public $app;

    /**
     * @var UnitHelper
     */
    public $helper;

    /**
     * Setup before each test
     */
    protected function setUp()
    {
        parent::setUp();

        !defined('_JBZOO') && define('_JBZOO', true);

        if (!defined('JBZOO_INIT')) {
            require_once PROJECT_ROOT . '/src/jbzoo/init.php';
        }

        $this->app = App::getInstance();

        $dumper = new PimpleDumper();
        $this->app->register($dumper);

        $this->helper = new UnitHelper();
    }
}
