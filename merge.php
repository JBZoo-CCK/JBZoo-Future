<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

require_once './vendor/autoload.php';


$finder = new Finder();

$finder
    ->files()
    ->in('./build/clover-php')
    ->name('*.php');

/** @var PHP_CodeCoverage $totalCoverage */
$totalCoverage = false;

/** @var SplFileInfo $file */
foreach ($finder as $file) {

    /** @var PHP_CodeCoverage $coverage */
    $coverage = include $file->getPathname();

    if (!$totalCoverage) {
        $totalCoverage = $coverage;
    } else {
        $totalCoverage->filter()->addFilesToWhitelist($coverage->filter()->getWhitelist());
        $totalCoverage->merge($coverage);
    }
}

print "\nGenerating code coverage report in HTML format ...";

// Based on PHPUnit_TextUI_TestRunner::doRun
$writer = new PHP_CodeCoverage_Report_HTML(
    'UTF-8',
    false, // 'reportHighlight'
    35, // 'reportLowUpperBound'
    70, // 'reportHighLowerBound'
    sprintf(
        ' and <a href="http://phpunit.de/">PHPUnit %s</a>',
        PHPUnit_Runner_Version::id()
    )
);

$writer->process($totalCoverage, 'build/total_html');

print " done\n";
print "See coverage/index.html\n";
