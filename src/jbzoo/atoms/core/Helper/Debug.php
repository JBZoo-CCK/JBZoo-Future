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

use JBZoo\CCK\Atom\Atom;
use JBZoo\CCK\Atom\Helper;
use JBZoo\Utils\Cli;
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
    /**
     * @var \JBDump
     */
    protected $_jbdump;

    /**
     * @var string
     */
    protected $_root;

    /**
     * @var array
     */
    protected $_config = [
        'mode'     => 'symfony', // jbdump|symfony|var_dump
        'log'      => 1,         // Log message
        'dump'     => 1,         // Show dumps of vars
        'sql'      => 1,         // Show SQL queries
        'profiler' => 1,         // Show profiler
        'trace'    => 1,         // Show backtraces
        'ip'       => [          // Ony for local or developer env!
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
        'personal' => [
            'ip' => [],
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
    public function __construct(Atom $atom, $helperName)
    {
        parent::__construct($atom, $helperName);

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
     * @param string $query
     * @codeCoverageIgnore
     */
    public function sql($query)
    {
        if ($this->isShow() && $this->_config['sql'] && $this->_jbdump) {
            if ($this->_jbdump) {
                $this->_jbdump->sql($query);
            } else {
                $this->dump((string)$query, false, 'SQL Query', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
            }
        }
    }

    /**
     * Dump variable
     *
     * @param mixed  $data
     * @param bool   $isDie
     * @param string $label
     * @param array  $trace
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @codeCoverageIgnore
     */
    public function dump($data, $isDie = false, $label = '...', $trace = null)
    {
        if ($this->isShow() && $this->_config['dump'] && $this->_jbdump) {
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
            if ($this->_config['mode'] == 'jbdump') {
                $this->_jbdump->dump($data, $label, ['trace' => $trace]);


            } elseif ($this->_config['mode'] == 'symfony' && class_exists('\Symfony\Component\VarDumper\VarDumper')) {
                VarDumper::dump($data);

                Cli::out('<style>.sf-dump{font-size:14px!important;}</style> <pre>' . $message . '</pre>');

            } elseif ($this->_config['mode'] == 'var_dump') {
                ob_start();
                var_dump($data);
                $output = ob_get_contents();
                ob_end_clean();

                // neaten the newlines and indents
                $output = preg_replace("#\]\=\>\n(\s+)#m", "]   =>   ", $output);

                Cli::out('<pre>' . $output . $message . '</pre>');
            }

            $isDie && die(255);
        }
    }

    /**
     * Mark for profiler
     *
     * @param string $label
     *
     * @codeCoverageIgnore
     */
    public function mark($label = '...')
    {
        if ($this->isShow() && $this->_config['profiler'] && $this->_jbdump) {
            $this->_jbdump->mark($label);
        }
    }

    /**
     * Log to file
     *
     * @param string $message
     * @param string $label
     * @param array  $params
     *
     * @codeCoverageIgnore
     */
    public function log($message, $label = '...', $params = null)
    {
        if ($this->isShow() && $this->_config['log'] && $this->_jbdump) {
            $trace = $params ?: debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $this->_jbdump->log($message, $label, ['trace' => $trace]);
        }
    }

    /**
     * Log message as php array (code)
     *
     * @param array  $array
     * @param string $arrayName
     */
    public function logArray($array, $arrayName = 'data')
    {
        if ($this->isShow() &&
            $this->_config['log'] &&
            $this->_jbdump &&
            method_exists($this->_jbdump, 'phpArray')
        ) {
            $arrayString = $this->_jbdump->phpArray((array)$array, $arrayName, true);
            $this->_jbdump->log(
                $arrayString,
                '$' . $arrayName,
                ['trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)]
            );
        }
    }

    /**
     * Show backtrace
     *
     * @param bool $isLog
     */
    public function trace($isLog = false)
    {
        if ($this->isShow() && $this->_config['trace'] && $this->_jbdump) {
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
                // @codeCoverageIgnoreStart
                $this->dump($result, 0, 'Backtrace', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
                // @codeCoverageIgnoreEnd
            }
        }
    }

    /**
     * Can we show debug information for current IP?
     *
     * @return bool
     */
    public function isShow()
    {
        $ip = Sys::IP(false);
        return in_array($ip, $this->_config['ip'], true);
    }
}
