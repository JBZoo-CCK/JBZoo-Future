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

# echo ""
# echo ">>> >>> Update PHP libs"
# composer config bin-dir     "../../bin"     --working-dir=./src/jbzoo
# composer config vendor-dir  "vendor"        --working-dir=./src/jbzoo
# composer update                             --working-dir=./src/jbzoo


# echo ""
# echo ">>> >>> Update JS libs"
# NODE_ENV=development npm install
# NODE_ENV=development ./node_modules/.bin/bower update
# NODE_ENV=development ./node_modules/.bin/gulp update

NODE_ENV=development ./node_modules/.bin/webpack    \
    --watch-aggregate-timeout=300                   \
    --watch                                         \
    --progress                                      \
    --colors
