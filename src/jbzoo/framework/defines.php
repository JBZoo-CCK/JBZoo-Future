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

use JBZoo\CCK\Atom\Atom;
use JBZoo\CCK\Atom\Core\Helper\Debug;
use JBZoo\CCK\Atom\Manager;
use JBZoo\Data\Data;
use JBZoo\Data\JSON;
use JBZoo\CCK\App;

/**
 * Get JBZoo Application instance
 *
 * @param string $helper
 * @return App|mixed
 */
function jbApp($helper = null)
{
    $app = App::getInstance();
    if (null !== $helper) {
        return $app[$helper];
    }

    return $app;
}

/**
 * @param $atomId
 * @return Atom|Manager
 */
function jbAtom($atomId = null)
{
    $app = App::getInstance();
    if (null !== $atomId) {
        return $app['atoms'][$atomId];
    }

    return $app['atoms'];
}

/**
 * @param array $data
 * @return Data
 */
function jbData($data = [])
{
    if ($data instanceof Data) {
        return $data;
    }

    if (is_string($data)) {
        $result = new JSON($data);
    } else {
        $result = new JSON((array)$data);
    }

    return $result;
}

/**
 * Translate text
 * @param string $message
 * @return string
 */
function jbt($message)
{
    $app = App::getInstance();
    return call_user_func_array(array($app['lang'], 'translate'), func_get_args());
}

// for custom method
if (!function_exists('jbd')) {

    /**
     * Dump anything
     *
     * @param mixed  $mixed
     * @param bool   $isDie
     * @param string $label
     * @return Debug|null
     */
    function jbd($mixed = '__no_dump__', $isDie = true, $label = '...')
    {
        $app = App::getInstance();

        if ($mixed === '__no_dump__') {
            return $app['debug'];
        }

        $app['debug']->dump($mixed, $isDie, $label, debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
    }
}
