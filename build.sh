#!/usr/bin/env sh

echo ""
echo ">>> Composer"
composer self-update
composer update --optimize-autoloader

echo ""
echo ">>> npm"
npm update

echo ""
echo ">>> Bower"
bower update

echo ""
echo ">>> Gulp"
gulp update

echo ""
echo ">>> Webpack"
webpack-dev-server --config=webpack.config.js --inline --hot --progress
