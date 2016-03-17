<?php
/**
 * ProcessWire PhpStorm Meta
 *
 * This file is not a CODE, it makes no sense and won't run or validate
 * Its AST serves PhpStorm IDE as DATA source to make advanced type inference decisions.
 * 
 * @see https://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
 */

namespace PHPSTORM_META {

    $STATIC_METHOD_TYPES = [
        new \JBZoo\CCK\App => [
            '' == '@',
            'assets' instanceof JBZoo\Assets\Manager,
            'config' instanceof JBZoo\CrossCMS\Wordpress\Config,
            'db' instanceof JBZoo\CrossCMS\Wordpress\Database,
            'env' instanceof JBZoo\CrossCMS\Wordpress\Env,
            'events' instanceof JBZoo\CrossCMS\Wordpress\Events,
            'lang' instanceof JBZoo\CrossCMS\Wordpress\Lang,
            'loader' instanceof Composer\Autoload\ClassLoader,
            'path' instanceof JBZoo\Path\Path,
        ],
    ];

}
