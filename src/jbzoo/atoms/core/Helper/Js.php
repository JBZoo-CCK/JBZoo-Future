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

use JBZoo\Assets\Asset\Asset;
use JBZoo\CCK\Atom\Helper;

/**
 * Class Js
 * @package JBZoo\CCK
 */
class Js extends Helper
{
    const GLOBAL_VAR = 'JBZooVars';

    /**
     * {@inheritdoc}
     */
    protected function _init()
    {
        $this->app['assets']->register(
            'var_' . self::GLOBAL_VAR . '_1',
            implode(PHP_EOL . ';', [
                '    window.' . self::GLOBAL_VAR . ' = {};',
                '    var dump = function(mixed, label, trace) {
                         if (label) {
                            console.log(label + \': \', mixed);
                         } else {
                            console.log(mixed);
                         }
                         if (trace) { console.trace(); }
                     };
                ',
            ]),
            [],
            ['type' => Asset::TYPE_JS_CODE]
        );
    }

    /**
     * @param string $varname
     * @param mixed  $value
     * @param bool   $isGlobal
     */
    public function addVar($varname, $value, $isGlobal = false)
    {
        if ($isGlobal) {
            $fullName = 'window.' . $varname;
        } else {
            $fullName = 'window.' . self::GLOBAL_VAR . "['{$varname}']";
        }

        $this->app['assets']->add(
            'var_' . $varname . '_' . (int)$isGlobal,
            '    ' . $fullName . ' = ' . $this->toJSON($value) . ';' . PHP_EOL,
            ['var_' . self::GLOBAL_VAR . '_1'],
            ['type' => Asset::TYPE_JS_CODE]
        );
    }

    /**
     * Conver PHP var to valid JSON
     *
     * @param $vars
     * @return mixed|string
     */
    public function toJSON($vars)
    {
        if (is_object($vars)) {
            $vars = (array)$vars;
        }

        if (is_array($vars) && count($vars) === 0) {
            return '{}';
        }

        return json_encode($vars);
    }
}
