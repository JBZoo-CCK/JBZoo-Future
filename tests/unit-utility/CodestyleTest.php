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
    protected $_packageDesc = array(
        'This file is part of the JBZoo CCK package.',
        'For the full copyright and license information, please view the LICENSE',
        'file that was distributed with this source code.',
    );

    /**
     * Valid copyright header
     * @var array
     */
    protected static $_validHeader = array(
        '<?php',
        '/**',
        ' * _VENDOR_ _PACKAGE_',
        ' *',
        ' * _DESCRIPTION_',
        ' *',
        ' * @package    _PACKAGE_',
        ' * @license    _LICENSE_',
        ' * @copyright  _COPYRIGHTS_',
        ' * @link       _LINK_',
    );

    /**
     * Ignore list for
     * @var array
     */
    protected static $_excludeFiles = array(
        '.idea',
        '.git',
        'bin',
        'build',
        'logs',
        'resources',
        'vendor',
    );

    /**
     * @throws \Exception
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setUp()
    {
        parent::setUp();

        //@codeCoverageIgnoreStart
        if (!$this->_packageName) {
            throw new Exception('$this->_packageName is undefined!');
        }
        //@codeCoverageIgnoreEnd

        $this->_replace = array(
            '_LINK_'        => $this->_packageLink,
            '_NAMESPACE_'   => '_VENDOR_\_PACKAGE_',
            '_COPYRIGHTS_'  => 'Copyright (C) JBZoo.com,  All rights reserved.',
            '_PACKAGE_'     => $this->_packageName,
            '_LICENSE_'     => $this->_packageLicense,
            '_VENDOR_'      => $this->_packageVendor,
            '_DESCRIPTION_' => implode($this->_le . ' * ', $this->_packageDesc),
        );
    }

    /**
     * Test copyright headers
     *
     * @return void
     */
    public function testHeaders()
    {
        $finder = new Finder();

        $finder
            ->files()
            ->in([PROJECT_TESTS, PROJECT_SRC])
            ->name('*.php');

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {

            $content = openFile($file->getPathname());

            // build copyrights
            $valid = $this->_replaceCopyright(implode(self::$_validHeader, $this->_le));
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
            ->exclude(self::$_excludeFiles);

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
            ->exclude(self::$_excludeFiles)
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
