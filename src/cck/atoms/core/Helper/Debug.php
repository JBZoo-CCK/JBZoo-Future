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
use JBZoo\Data\Data;
use JBZoo\Utils\Filter;
use JBZoo\Utils\FS;
use JBZoo\Utils\Sys;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class Debug
 * @package JBZoo\CCK
 */
class Debug extends Helper
{
    const MODE_NONE     = 'none';
    const MODE_JBDUMP   = 'jbdump';
    const MODE_SYMFONY  = 'symfony';
    const MODE_VAR_DUMP = 'var_dump';

    /**
     * @var \JBDump
     */
    protected $_jbdump;

    /**
     * @var string
     */
    protected $_root;

    /**
     * @var Data
     */
    protected $_config = [
        'dumper'   => self::MODE_JBDUMP,    // See class constanses
        'log'      => 0,                    // Log message
        'sql'      => 0,                    // Show SQL queries
        'profiler' => 0,                    // Show profiler
        'trace'    => 0,                    // Show backtraces
        'ip'       => [                     // Ony for local or developer env!
            '127.0.0.1',
        ],
    ];

    /**
     * Cleanup global JBDump config
     * @var array
     */
    protected $_params = [
        'log'      => [
            //'format' => '{DATETIME}    {CLIENT_IP}    {FILE}    {NAME}    {JBDUMP_MESSAGE}',
        ],
        'profiler' => [
            'render'     => 4, // Bit: 1 - log; 2 - echo; 4 - table; 8 - chart; 16 - total
            'auto'       => 1,
            'showStart'  => 0,
            'showEnd'    => 1,
            'showOnAjax' => 0,
        ],
        'dump'     => [
            'maxDepth'    => 5,
            'expandLevel' => 3,
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->reInitConfig();

        // Only for developer env
        if ($this->isShow() && class_exists('\JBDump')) {
            $this->_root = $this->app['path']->get('jbzoo:..');

            $jbdump = \JBDump::i();

            // Set paths
            $this->_params['log']['path'] = $this->_root . '/../logs';
            $this->_params['root']        = $this->_root;

            $jbdump->setParams($this->_params);

            $this->_jbdump = $jbdump;
        }
    }

    /**
     * Load config from database
     */
    public function reInitConfig()
    {
        $store  = jbdata($this->app['cfg']->find('atom.core'));
        $stored = $store ? $store->get('debug', [], 'arr') : [];

        $config = jbdata(array_merge((array)$this->_config, $stored));
        $config->set('ip', $config->get('ip', '', 'parseLines'));

        $this->_config = $config;
    }

    /**
     * @param $query
     * @return \JBDump
     */
    public function sql($query)
    {
        $isSql = $this->_isSql();

        if ($isSql && $this->_isDumper(self::MODE_JBDUMP)) {
            $this->_jbdump->sql((string)$query);
            return true;

        } elseif ($isSql) {
            $this->dump((string)$query, false, 'SQL Query', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
            return true;
        }

        return false;
    }

    /**
     * Dump any variables
     *
     * @param mixed  $data
     * @param bool   $isDie
     * @param string $label
     * @param array  $trace
     * @return bool
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function dump($data, $isDie = false, $label = '...', $trace = null)
    {
        if (!$this->isShow()) {
            return false;
        }

        $trace     = $trace ?: debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $traceItem = $trace[0];

        foreach ($trace as $item) {
            if (isset($item['file']) && $item['function'] != 'call_user_func_array') {
                $traceItem = $item;
                break;
            }
        }

        $relative = FS::getRelative($traceItem['file'], $this->_root, '/', false);
        $message  = sprintf('%s = "%s:%s" %s', $label, $relative, $traceItem['line'], ($isDie ? ' / AutoDie' : ''));


        // Select Dumper and show var!
        if ($this->_isDumper(self::MODE_JBDUMP)) {
            $this->_jbdump->dump($data, $label, ['trace' => $trace]);
        }

        if ($this->_isDumper(self::MODE_SYMFONY)) {
            VarDumper::dump($data);
            echo '<style>.sf-dump{font-size:14px!important;}</style> <pre>' . $message . '</pre>';
        }


        if ($this->_isDumper(self::MODE_VAR_DUMP)) {
            ob_start();
            var_dump($data);
            $output = ob_get_contents();
            $output = preg_replace("#\]\=\>\n(\s+)#m", "]   =>   ", $output); // remove the newlines and indents
            ob_end_clean();

            echo '<pre>' . $output . $message . '</pre>';
        }


        if ($isDie) { // Die, die, die my darling!
            die(255);
        }

        return true;
    }

    /**
     * Mark for profiler
     * @param string $label
     * @return bool
     */
    public function mark($label = '...')
    {
        if (!$this->_isProfiler()) {
            return false;
        }

        $this->_jbdump->mark($label);
        return true;
    }

    /**
     * Log to file
     *
     * @param string $message
     * @param string $label
     * @param array  $trace
     * @return bool
     */
    public function log($message, $label = '...', $trace = null)
    {
        if (!$this->_isLog()) {
            return false;
        }

        $trace = $trace ?: debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $this->_jbdump->log($message, $label, ['trace' => $trace]);
        return true;
    }

    /**
     * Log message as php array (code)
     *
     * @param array  $array
     * @param string $arrayName
     * @return bool
     */
    public function logArray($array, $arrayName = 'data')
    {
        if (!$this->_isLog()) {
            return false;
        }

        $arrayString = $this->_jbdump->phpArray((array)$array, $arrayName, true);

        $this->_jbdump->log(
            $arrayString,
            '$' . $arrayName,
            ['trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)]
        );

        return true;
    }

    /**
     * Show backtrace
     *
     * @param bool $isLog
     * @return bool
     */
    public function trace($isLog = false)
    {
        if (!$this->_isTrace()) {
            return false;
        }

        // Render simple trace data
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
        $output = ob_get_contents();
        ob_end_clean();

        // Get lines
        $lines = explode("\n", trim($output));
        $root  = FS::clean($this->_root, '/');

        // Combine useful array
        $result = array();
        foreach ($lines as $line) {
            if (preg_match('/#(.*?)  (.*?) called at \[(.*):(.*)\]/', $line, $mathes)) {
                $filepath = Filter::_($mathes[3], function ($path) use ($root) {
                    $path    = FS::clean($path, '/');
                    $relPath = preg_replace('#^' . preg_quote($root) . '#i', '', $path);
                    $relPath = ltrim($relPath, '/');
                    return $relPath;
                });

                $result[$mathes[1] . ' ' . $mathes[2]] = $filepath . ':' . $mathes[4];

            } elseif (preg_match('/#(.*?)  (.*)/', $line, $mathes)) {
                $result[$mathes[1] . ' ' . $mathes[2]] = 'Undefined path!';

            } else {
                $result[$line] = '';
            }
        }

        // Show me!
        if ($isLog) {
            $this->log($result, 'Backtrace', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        } else {
            $this->dump($result, 0, 'Backtrace', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
        }

        return true;
    }

    /**
     * Can we show debug information for current IP?
     *
     * @return bool
     */
    public function isShow()
    {
        $whiteList = $this->_config->get('ip', [], 'arr');
        if (count($whiteList) == 0) {
            return false;
        }

        return in_array(Sys::IP(false), $whiteList, true);
    }

    /**
     * @param string $isDumper
     * @return bool
     */
    protected function _isDumper($isDumper)
    {
        $currentMode = $this->_config->get('dumper', self::MODE_NONE);

        if ($currentMode === self::MODE_NONE || !$this->isShow()) {
            return false;


        } elseif ($currentMode === self::MODE_JBDUMP
            && $isDumper === self::MODE_JBDUMP
            && $this->_jbdump
        ) {
            return true;


        } elseif ($currentMode === self::MODE_VAR_DUMP
            && $isDumper === self::MODE_VAR_DUMP
        ) {
            return true;


        } elseif ($currentMode === self::MODE_SYMFONY
            && $isDumper === self::MODE_SYMFONY
            && class_exists('\Symfony\Component\VarDumper\VarDumper')
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function _isSql()
    {
        return $this->isShow() && $this->_config->get('sql', 0, 'bool');
    }

    /**
     * @return bool
     */
    protected function _isLog()
    {
        $result = $this->isShow()
            && $this->_config->get('log', 0, 'bool')
            && $this->_jbdump
            && method_exists($this->_jbdump, 'phpArray');

        return $result;
    }

    /**
     * @return bool
     */
    protected function _isTrace()
    {
        return $this->isShow() && $this->_config->get('trace', 0, 'bool') && $this->_jbdump;
    }

    /**
     * @return bool
     */
    protected function _isProfiler()
    {
        return $this->isShow() && $this->_config->get('profiler', 0, 'bool') && $this->_jbdump;
    }
}
