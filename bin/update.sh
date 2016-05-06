#!/usr/bin/env sh

echo ">>> >>> Composer"
echo "TODO: Remove vendor"
composer update --working-dir=src/jbzoo --optimize-autoloader

echo ""
echo ">>> >>> npm"
echo "TODO: Remove node_modules"
NODE_ENV=development npm install

echo ""
echo ">>> >>> Bower"
echo "TODO: Remove bower_components"
NODE_ENV=development bower update

echo ""
echo ">>> >>> Gulp"
NODE_ENV=development gulp update

echo ""
echo ">>> >>> Webpack"
NODE_ENV=development webpack --progress -v

echo "TODO: Joomla - install"
echo "TODO: Joomla - PHPUnit Plugin Install"
echo "TODO: Joomla - JBZooCCK Plugin Install"
echo "TODO: Joomla - Create symlinks"

echo "TODO: Wordpress - install"
echo "TODO: Wordpress - PHPUnit Plugin Install"
echo "TODO: Wordpress - JBZooCCK Plugin Install"
echo "TODO: Wordpress - Create symlinks"

echo "TODO: Create empty folders : build, logs, tmp"
