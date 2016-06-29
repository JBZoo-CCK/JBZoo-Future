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
 * @codingStandardsIgnoreFile
 */

namespace JBZoo\CCK;

if (!defined('JBZOO')) {
    define('JBZOO', true);

    // @codeCoverageIgnoreStart
    if (!function_exists('composerRequire_JBZoo')) {
        if ($composerPath = realpath(__DIR__ . '/../../vendor/autoload.php')) { // developer mode
            define('JBZOO_DEV', true);
            /** @noinspection PhpIncludeInspection */
            require_once $composerPath;

        } elseif ($composerPath = realpath(__DIR__ . '/libraries/autoload.php')) { // production mode
            define('JBZOO_DEV', false);
            /** @noinspection PhpIncludeInspection */
            require_once $composerPath;

        } else {
            throw new \Exception('Composer autoload not found!');
        }
    } else {
        define('JBZOO_DEV', true);
    }
    // @codeCoverageIgnoreEnd

    $app = App::getInstance();

    try {
        $app->init();
    } catch (\Exception $e) {
        $app->error($e->getMessage());
    }
}
