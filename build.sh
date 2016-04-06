#!/usr/bin/env sh

echo ""
echo ">>> Composer"
composer self-update
composer update --optimize-autoloader

echo ""
echo ">>> npm"
npm install

echo ""
echo ">>> Bower"
bower update

echo ""
echo ">>> Gulp"
gulp update

echo ""
echo ">>> Webpack"
webpack --config=webpack.config.js --progress -v
