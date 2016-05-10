#!/usr/bin/env sh

echo ""
echo ">>> >>> GIT"
git reset --hard


echo ""
echo ">>> >>> Remove dirs"
rm -fr ./bin
rm -fr ./vendor
rm -fr ./node_modules
rm -fr ./src/jbzoo/vendor
rm -fr ./bower_components
