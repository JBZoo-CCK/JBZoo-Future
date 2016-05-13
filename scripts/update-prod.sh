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

echo ">>> >>> Composer: Cleanup"
rm -fr ./bin
rm -fr ./vendor
rm -fr ./src/cck/libraries


echo ">>> >>> Composer: Change config"
composer config bin-dir     "bin"       --working-dir=./src/cck
composer config vendor-dir  "libraries" --working-dir=./src/cck


echo ">>> >>> Composer: Install cleanup plugin"
composer require jbzoo/composer-cleanup:1.x-dev     \
    --working-dir=./src/cck                         \
    --no-update                                     \
    --update-no-dev                                 \
    --no-interaction


echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/cck     \
    --no-dev                    \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress


echo ""
echo ">>> >>> NPM: Cleanup"
rm -fr ./node_modules
echo ">>> >>> NPM: Install"
npm install


echo ""
echo ">>> >>> Bower: Cleanup"
rm -fr ./bower_components
echo ">>> >>> Bower: Update"
./node_modules/.bin/bower update


echo ""
echo ">>> >>> Gulp: Update"
./node_modules/.bin/gulp update


echo ""
echo ">>> >>> Webpack"
./node_modules/.bin/webpack -v


echo ""
echo ">>> >>> Clean up all!"
rm   ./src/cck/bin/lessc.bat
rm   ./src/cck/bin/lessc
find ./src  -name "*.jsx"           -type f -delete
find ./src  -name "*.map"           -type f -delete
find ./src  -name "composer.json"   -type f -delete
find ./src  -name "composer.lock"   -type f -delete
find ./src                          -type d -empty -delete
