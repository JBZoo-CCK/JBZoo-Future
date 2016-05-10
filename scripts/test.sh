#!/usr/bin/env sh

#
# JBZoo CCK
#
# This file is part of the JBZoo CCK package.
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @package   CCK
# @license   Proprietary http://jbzoo.com/license
# @copyright Copyright (C) JBZoo.com,  All rights reserved.
# @link      http://jbzoo.com
#

echo ""
echo ">>> >>> PHPUnit: Joomla"
sh ./bin/phpunit                                    \
    --configuration ./phpunit-joomla.xml.dist


echo ""
echo ">>> >>> PHPUnit: Wordpress"
sh ./bin/phpunit                                    \
    --configuration ./phpunit-wordpress.xml.dist


echo ""
echo ">>> >>> PHPUnit: Utility"
sh ./bin/phpunit                                    \
    --configuration ./phpunit-utility.xml.dist      \
    ./tests/unit/utility/CodeStyleTest.php


echo ""
echo ">>> >>> PHP: Statistics"
sh ./bin/phpmd  ./src/jbzoo                         \
    text                                            \
    ./src/jbzoo/vendor/jbzoo/misc/phpmd/jbzoo.xml   \
    --verbose


echo ""
echo ">>> >>> PHP: Code Style"
sh ./bin/phpcs  ./src/jbzoo                                             \
    --extensions=php                                                    \
    --standard=./src/jbzoo/vendor/jbzoo/misc/phpcs/JBZoo/ruleset.xml    \
    --report=full


echo ""
echo ">>> >>> PHP: Copy&Paste"
sh ./bin/phpcpd ./src/jbzoo


echo ""
echo ">>> >>> PHP: loc"
sh ./bin/phploc ./src/jbzoo --verbose
