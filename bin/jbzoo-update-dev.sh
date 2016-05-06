#!/usr/bin/env sh

echo ">>> >>> Prepare paths"
mkdir -p build/clover_xml
mkdir -p build/clover_html
mkdir -p build/browser_html
mkdir -p build/logs
mkdir -p build/misc


echo ">>> >>> Composer"
rm -fr src/jbzoo/vendor

composer update                 \
    --optimize-autoloader       \
    --working-dir=src/jbzoo     \
    --no-interaction            \
    --no-progress


echo ""
echo ">>> >>> npm"
rm -fr node_modules
NODE_ENV=development npm install


echo ""
echo ">>> >>> Bower"
rm -fr bower_components
NODE_ENV=development bower update


echo ""
echo ">>> >>> Gulp"
NODE_ENV=development gulp update


echo ""
echo ">>> >>> Webpack"
NODE_ENV=development webpack --progress -v
