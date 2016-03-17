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
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class CodeStyleTest
 * @package JBZoo\PHPUnit
 */
class CodeStyleTest extends PHPUnit
{
    protected $_le = "\n";
    protected $_replace = array();

    protected $_packageName = 'CCK';
    protected $_packageLink = 'http://jbzoo.com';
    protected $_packageLicense = 'Proprietary http://jbzoo.com/license';
    protected $_packageVendor = 'JBZoo';
    protected $_packageDesc = [
        'This file is part of the JBZoo CCK package.',
        'For the full copyright and license information, please view the LICENSE',
        'file that was distributed with this source code.',
    ];

    /**
     * Ignore list for
     * @var array
     */
    protected $_excludePaths = array(
        '.idea',
        '.git',
        'bin',
        'build',
        'logs',
        'resources',
        'vendor',
    );

    /**
     * Before test
     */
    public function setUp()
    {
        $this->_replace = array(
            '_LINK_'       => $this->_packageLink,
            '_NAMESPACE_'  => '_VENDOR_\_PACKAGE_',
            '_COPYRIGHTS_' => 'Copyright (C) JBZoo.com,  All rights reserved.',
            '_PACKAGE_'    => $this->_packageName,
            '_LICENSE_'    => $this->_packageLicense,
            '_VENDOR_'     => $this->_packageVendor,
        );
    }

    /**
     * Test copyright headers of PHP files
     */
    public function testHeadersPHP()
    {
        $valid = $this->_replaceCopyright(implode([
            '<?php',
            '/**',
            ' * _VENDOR_ _PACKAGE_',
            ' *',
            ' * ' . implode($this->_le . ' * ', $this->_packageDesc),
            ' *',
            ' * @package    _PACKAGE_',
            ' * @license    _LICENSE_',
            ' * @copyright  _COPYRIGHTS_',
            ' * @link       _LINK_',
        ], $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.php');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {

            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }

    /**
     * Test copyright headers of JS files
     */
    public function testHeadersJS()
    {
        $valid = $this->_replaceCopyright(implode([
            '/**',
            ' * _VENDOR_ _PACKAGE_',
            ' *',
            ' * ' . implode($this->_le . ' * ', $this->_packageDesc),
            ' *',
            ' * @package    _PACKAGE_',
            ' * @license    _LICENSE_',
            ' * @copyright  _COPYRIGHTS_',
            ' * @link       _LINK_',
            ' */',
            '',
        ], $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.js')
            ->notName('*.min.js');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }

    /**
     * Test copyright headers of CSS files
     */
    public function testHeadersCSS()
    {
        $valid = $this->_replaceCopyright(implode([
            '/**',
            ' * _VENDOR_ _PACKAGE_',
            ' *',
            ' * ' . implode($this->_le . ' * ', $this->_packageDesc),
            ' *',
            ' * @package    _PACKAGE_',
            ' * @license    _LICENSE_',
            ' * @copyright  _COPYRIGHTS_',
            ' * @link       _LINK_',
            ' */',
            '',
        ], $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.css')
            ->notName('*.min.css');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }

    /**
     * Test copyright headers of LESS files
     */
    public function testHeadersLESS()
    {
        $valid = $this->_replaceCopyright(implode([
            '//',
            '// _VENDOR_ _PACKAGE_',
            '//',
            '// ' . implode($this->_le . '// ', $this->_packageDesc),
            '//',
            '// @package    _PACKAGE_',
            '// @license    _LICENSE_',
            '// @copyright  _COPYRIGHTS_',
            '// @link       _LINK_',
            '//',
            '',
        ], $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.less');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }

    /**
     * Test copyright headers of XML files
     */
    public function testHeadersXML()
    {
        $valid = $this->_replaceCopyright(implode([
            '<?xml version="1.0" encoding="UTF-8" ?>',
            '<!--',
            '    _VENDOR_ _PACKAGE_',
            '',
            '    ' . implode($this->_le . '    ', $this->_packageDesc),
            '',
            '    @package    _PACKAGE_',
            '    @license    _LICENSE_',
            '    @copyright  _COPYRIGHTS_',
            '    @link       _LINK_',
            '-->',
        ], $this->_le));

        $finder = new Finder();
        $finder
            ->files()
            ->in(PROJECT_ROOT)
            ->exclude($this->_excludePaths)
            ->name('*.xml')
            ->name('*.xml.dist');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {

            $content = openFile($file->getPathname());
            isContain($valid, $content, false, 'File has no valid header: ' . $file);
        }
    }

    /**
     * Test line endings
     */
    public function testFiles()
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in([PROJECT_ROOT])
            ->exclude($this->_excludePaths);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());

            isNotContain("\r", $content, false, 'File has \r symbol: ' . $file);
            isNotContain("\t", $content, false, 'File has \t symbol: ' . $file);
        }
    }

    /**
     * Try to find cyrilic symbols in the code
     */
    public function testCyrillic()
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in([PROJECT_ROOT])
            ->exclude($this->_excludePaths)
            ->exclude('tests');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $content = openFile($file->getPathname());
            isNotLike('#[А-Яа-яЁё]#ius', $content, 'File has no valid chars: ' . $file);
        }
    }

    /**
     * Render copyrights
     * @param $text
     * @return mixed
     */
    protected function _replaceCopyright($text)
    {
        foreach ($this->_replace as $const => $value) {
            $text = str_replace($const, $value, $text);
        }

        return $text;
    }
}
