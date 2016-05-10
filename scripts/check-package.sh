#!/usr/bin/env sh

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
