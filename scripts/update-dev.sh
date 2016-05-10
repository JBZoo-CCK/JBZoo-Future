#!/usr/bin/env sh

echo "-= Update Project for Developing =- "
echo ">>> >>> Prepare paths"
mkdir -p ./build/clover_xml
mkdir -p ./build/clover_html
mkdir -p ./build/browser_html
mkdir -p ./build/logs
mkdir -p ./build/misc


echo ""
echo ">>> >>> Composer: Cleanup"
rm -fr ./src/jbzoo/vendor
rm -fr ./vendor
rm -fr ./bin


echo ""
echo ">>> >>> Composer: Change configs"
composer config bin-dir     "../../bin"     --working-dir=./src/jbzoo
composer config vendor-dir  "vendor"        --working-dir=./src/jbzoo


echo ""
echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/jbzoo   \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress


echo ""
echo ">>> >>> NPM: Cleanup"
rm -fr ./node_modules
echo ">>> >>> NPM: Install"
NODE_ENV=development npm install


echo ""
echo ">>> >>> Bower: Cleanup"
rm -fr ./bower_components
echo ">>> >>> Bower: Update"
NODE_ENV=development sh ./node_modules/.bin/bower update


echo ""
echo ">>> >>> Gulp: Update"
NODE_ENV=development sh ./node_modules/.bin/gulp update


echo ""
echo ">>> >>> Webpack"
NODE_ENV=development sh ./node_modules/.bin/webpack -v
