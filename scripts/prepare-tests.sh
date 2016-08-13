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

ROOT="`pwd`"
JOOMLA="`pwd`/resources/cck-joomla"
WORDPRESS="`pwd`/resources/cck-wordpress"
WORKING_DIR="./src/cck"


echo ">>> >>> Composer: Cleanup"
rm -rf ./bin
rm -rf ./vendor
rm -rf ./src/cck/libraries
rm     ./src/cck/composer.lock


echo ""
echo ">>> >>> Composer: Change configs"
composer config bin-dir     "../../bin"     --working-dir=$WORKING_DIR
composer config vendor-dir  "../../vendor"  --working-dir=$WORKING_DIR


echo ""
echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=$WORKING_DIR  \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress


