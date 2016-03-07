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
            'atoms' instanceof JBZoo\CCK\Atom\Manager,
            'config' instanceof JBZoo\CrossCMS\Joomla\Config,
            'db' instanceof JBZoo\CrossCMS\Joomla\Database,
            'env' instanceof JBZoo\CrossCMS\Joomla\Env,
            'events' instanceof JBZoo\CrossCMS\Joomla\Events,
            'header' instanceof JBZoo\CrossCMS\Joomla\Header,
            'lang' instanceof JBZoo\CrossCMS\Joomla\Lang,
            'loader' instanceof Composer\Autoload\ClassLoader,
            'path' instanceof JBZoo\Path\Path,
            'request' instanceof JBZoo\CrossCMS\Joomla\Request,
        ],
    ];

}
