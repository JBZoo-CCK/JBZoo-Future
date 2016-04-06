#!/usr/bin/env sh

echo ">>> >>> Composer"
composer self-update
composer update --optimize-autoloader

echo ""
echo ">>> >>> npm"
NODE_ENV=development npm install

echo ""
echo ">>> >>> Bower"
NODE_ENV=development bower update

echo ""
echo ">>> >>> Gulp"
NODE_ENV=development gulp update

echo ""
echo ">>> >>> Webpack"
NODE_ENV=development webpack --progress -v

echo "TODO: Joomla install"
echo "TODO: Wordpress install"

