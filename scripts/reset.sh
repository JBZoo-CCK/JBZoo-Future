#!/usr/bin/env sh

echo ""
echo ">>> >>> GIT"
git reset --hard

echo ""
echo ">>> >>> Remove dirs"
rm -fr ./src/jbzoo/vendor
rm -fr ./vendor
rm -fr ./bin
rm -fr ./node_modules
rm -fr ./bower_components
