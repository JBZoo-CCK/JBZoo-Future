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

WORKING_DIR="./src/cck"

echo ">>> >>> Composer: Update"
composer config bin-dir     "../../bin"     --working-dir=$WORKING_DIR
composer config vendor-dir  "../../vendor"  --working-dir=$WORKING_DIR
composer update                 \
    --working-dir=$WORKING_DIR  \
    --optimize-autoloader


echo ""
echo ">>> >>> NPM: Install"
NODE_ENV=development npm install


echo ""
echo ">>> >>> Bower: Update"
NODE_ENV=development ./node_modules/.bin/bower update


echo ""
echo ">>> >>> Gulp: Update"
NODE_ENV=development ./node_modules/.bin/gulp update


echo ""
echo ">>> >>> Webpack"
NODE_ENV=development ./node_modules/.bin/webpack -v
