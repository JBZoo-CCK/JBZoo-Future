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

use Symfony\Component\Finder\Finder;

/**
 * Class Utility_CodeStyleTest
 * @package JBZoo\PHPUnit
 */
class Utility_CodeStyleTest extends Codestyle
{
    protected $_packageName = 'CCK';
    protected $_packageLink = 'http://jbzoo.com';
    protected $_packageLicense = 'Proprietary http://jbzoo.com/license';

    /**
     * Valid header for PHP files
     * @var array
     */
    protected $_validHeaderPHP = array(
        '<?php',
        '/**',
        ' * _VENDOR_ _PACKAGE_',
        ' *',
        ' * _DESCRIPTION_PHP_',
        ' *',
        ' * @package    _PACKAGE_',
        ' * @license    _LICENSE_',
        ' * @copyright  _COPYRIGHTS_',
        ' * @link       _LINK_',
    );

    /**
     * Valid header for JavaScript files
     * @var array
     */
    protected $_validHeaderJS = array(
        '/**',
        ' * _VENDOR_ _PACKAGE_',
        ' *',
        ' * _DESCRIPTION_JS_',
        ' *',
        ' * @package    _PACKAGE_',
        ' * @license    _LICENSE_',
        ' * @copyright  _COPYRIGHTS_',
        ' * @link       _LINK_',
        ' */',
        '',
        '\'use strict\';',
        '',
    );

    /**
     * Test copyright headers of SH files
     */
    public function testHeadersSH()
    {
        $valid = $this->_prepareTemplate(implode($this->_validHeaderSH, $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.sh');

        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }
}
