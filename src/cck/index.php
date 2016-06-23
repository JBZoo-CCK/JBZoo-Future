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
 *
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 * @codingStandardsIgnoreFile
 */

use JBZoo\Utils\Env;

if (!class_exists('JBZooPHPUnitCoverageWrapper')) {

    /**
     * Class JBZooPHPUnitCoverageWrapper
     */
    class JBZooPHPUnitCoverageWrapper
    {
        /**
         * @var PHP_CodeCoverage
         */
        protected $_coverage;

        /**
         * @var string
         */
        protected $_covRoot;

        /**
         * @var string
         */
        protected $_covDir;

        /**
         * @var string
         */
        protected $_covHash;

        /**
         * @var string
         */
        protected $_covResult;

        /**
         * JBZooPHPUnit_Coverage constructor.
         * @SuppressWarnings(PHPMD.Superglobals)
         */
        public function __construct()
        {
            if (Env::hasXdebug()) {

                $request = $_REQUEST;
                if (isset($request['nocache'])) {
                    unset($request['nocache']);
                }

                if (!isset($request['_cov'])) {
                    $request['_cov'] = isset($request['act']) ? $request['act'] : 'request';
                }

                $this->_covRoot = realpath(__DIR__ . '/../..');
                $this->_covDir  = realpath($this->_covRoot . '/src');
                $this->_covHash = implode('_', [
                    str_replace('.', '_', $request['_cov']),
                    md5(serialize($request))
                ]);

                $this->_covResult = realpath($this->_covRoot . '/build/coverage_cov/') . '/' . $this->_covHash . '.cov';

                $covFilter = new PHP_CodeCoverage_Filter();
                $covFilter->addDirectoryToWhitelist($this->_covDir);
                $this->_coverage = new PHP_CodeCoverage(null, $covFilter);
            }
        }

        /**
         * Save report
         */
        public function __destruct()
        {
            if ($this->_coverage) {
                $this->_coverage->stop();
                (new PHP_CodeCoverage_Report_PHP())->process($this->_coverage, $this->_covResult);
            }
        }

        /**
         * @param Closure $callback
         * @return mixed
         */
        public function init(\Closure $callback)
        {
            if ($this->_coverage) {
                $this->_coverage->start($this->_covHash, true);
                return $callback();
            } else {
                return $callback();
            }
        }
    }
}

$coverageWrapper = new JBZooPHPUnitCoverageWrapper();
return $coverageWrapper->init(function () {
    return include __DIR__ . '/_index.php';
});
