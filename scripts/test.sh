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

MISC_PATH="./build/misc"
SRC_PATH="./src/cck"


#### PHPUnit ###########################################################################################################


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


#### Clone JBZoo/Misc ##################################################################################################

echo ""
echo ">>> >>> Prepare JBZoo/Misc"

rm    -rf   $MISC_PATH
mkdir -p    $MISC_PATH
composer                                    \
    create-project jbzoo/misc:1.x-dev       \
    $MISC_PATH                              \
    --keep-vcs


#### Statistics ########################################################################################################


echo ""
echo ">>> >>> PHP: Code Style"
sh ./bin/phpcs                                          \
    $SRC_PATH                                           \
    --standard="$MISC_PATH/phpcs/JBZoo/ruleset.xml"     \
    --extensions=php                                    \
    --report=full                                       \
    --report-width=180                                  \
    --tab-width=4                                       \
    --report=full


# echo ""
# echo ">>> >>> PHP: Mess Detector"
# sh ./bin/phpmd                                                                  \
#     $SRC_PATH                                                                   \
#     text                                                                        \
#     "$MISC_PATH/phpmd/jbzoo.xml"                                                \
#     --exclude **/symfony/*,**/oyejorge/*,**/composer/,**/pimple/,**/jbdump/*    \
#     --verbose
#
#
# echo ""
# echo ">>> >>> PHP: Copy&Paste"
# sh ./bin/phpcpd                                     \
#     $SRC_PATH
#
#
# echo ""
# echo ">>> >>> PHP: loc"
# sh ./bin/phploc                                     \
#     $SRC_PATH                                       \
#     --verbose
