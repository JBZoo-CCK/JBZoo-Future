<?php
/**
 * JBZoo Console
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Console
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/Console
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

namespace JBZoo\Console\Command;

use JBZoo\Console\Command;
use JBZoo\Utils\Filter;
use JBZoo\Utils\Url;
use SuperClosure\Serializer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Cms
 * @package JBZoo\Console\Command
 */
class Cms extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('cms')
            ->setDescription('Run CMS in web browser emulation mode. All params must by serialized!')
            // test
            ->addOption('test-func', null, InputOption::VALUE_OPTIONAL, 'Serialized test of Closure type')
            ->addOption('test-name', null, InputOption::VALUE_OPTIONAL, 'Name of test')
            // phpunit
            ->addOption('phpunit-test', null, InputOption ::VALUE_OPTIONAL, 'PHPUnit test file')
            ->addOption('phpunit-clover', null, InputOption ::VALUE_OPTIONAL, 'PHPUnit clover xml path')
            ->addOption('phpunit-html', null, InputOption ::VALUE_OPTIONAL, 'PHPUnit clover html path')
            ->addOption('phpunit-config', null, InputOption ::VALUE_OPTIONAL, 'PHPUnit configuration path')
            // env
            ->addOption('env-method', null, InputOption::VALUE_OPTIONAL, 'GET or POST', 'GET')
            ->addOption('env-path', null, InputOption ::VALUE_OPTIONAL, 'Query path', '/')
            ->addOption('env-request', null, InputOption::VALUE_OPTIONAL, 'Query string', '')
            ->addOption('env-cms', null, InputOption ::VALUE_OPTIONAL, 'CMS type');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) // @codingStandardsIgnoreLine
    {
        $this->_executePrepare($input, $output);

        define('__CMS__', $this->_getOpt('env-cms'));

        $this->_prepareServer();
        $this->_prepareTest();
        $this->_preparePHPUnit();

        \PHPUnit_TextUI_Command::main();
    }

    /**
     * Prepare PHPUnit
     */
    protected function _preparePHPUnit()
    {
        $args = implode(' ', [
            'phpunit',
            $this->_getOpt('phpunit-test'),
            '--configuration ' . $this->_getOpt('phpunit-config'),
            '--coverage-clover ' . $this->_getOpt('phpunit-clover'),
            '--coverage-html ' . $this->_getOpt('phpunit-html'),
            '--stderr',
        ]);

        $_SERVER['argv'] = explode(' ', $args);
        $_SERVER['argc'] = count($_SERVER['argv']);
    }

    /**
     * Prepare test functions
     */
    protected function _prepareTest()
    {
        $GLOBALS['__TEST_NAME__'] = $this->_getOpt('test-name');
        $GLOBALS['__TEST_FUNC__'] = $this->_decodeTest($this->_getOpt('test-func'));
    }

    /**
     * Prepare web server (emulator)
     */
    protected function _prepareServer()
    {
        require_once PROJECT_ROOT . '/tests/autoload/browser_env.php';

        $method    = strtoupper($this->_getOpt('env-method'));
        $path      = $this->_getOpt('env-path');
        $queryVars = (array)$this->_getOpt('env-request');
        $query     = Url::build($queryVars);

        $_SERVER['QUERY_STRING']   = $query;
        $_SERVER['REQUEST_URI']    = $path;
        $_SERVER['REQUEST_METHOD'] = $method;

        if ($method == 'GET') {
            $_REQUEST               = $_GET = $queryVars;
            $_SERVER['REQUEST_URI'] = Url::addArg($queryVars, $_SERVER['REQUEST_URI']);
        } elseif ($method == 'POST') {
            $_REQUEST = $_POST = $queryVars;
        }
    }

    /**
     * @param string $name
     * @param null   $default
     * @return mixed
     */
    protected function _getOpt($name, $default = null)
    {
        $value = parent::_getOpt($name, $default);
        return $this->_decode($value);
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function _decode($string)
    {
        $string = Filter::stripQuotes($string);
        $string = base64_decode($string);
        $vars   = unserialize($string);

        return $vars;
    }

    /**
     * @param $serialized
     * @return \Closure
     */
    protected function _decodeTest($serialized)
    {
        $serializer = new Serializer();
        $function   = $serializer->unserialize($serialized);

        return $function;
    }
}
