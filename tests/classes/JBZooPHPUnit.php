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

        !defined('JBZOO') && define('JBZOO', true);

        if (!defined('JBZOO_INIT')) {
            require_once PROJECT_ROOT . '/src/jbzoo/init.php';
        }

        $this->app    = App::getInstance();
        $this->helper = new UnitHelper();

        // Dump container for autocomplete
        if (!defined('JBZOO_PIMPLE_INIT')) {
            define('JBZOO_PIMPLE_INIT', true);

            $dumper = new PimpleDumper();
            $this->app->register($dumper);
        }
    }
}
