#!/usr/bin/env sh

echo ">>> >>> Composer: Cleanup"
rm -fr ./src/jbzoo/vendor
rm -fr ./vendor
rm -fr ./bin

echo ">>> >>> Composer: Change config"
composer config bin-dir     "bin"     --working-dir=./src/jbzoo
composer config vendor-dir  "vendor"  --working-dir=./src/jbzoo

echo ">>> >>> Composer: Install cleanup plugin"
composer require jbzoo/composer-cleanup:1.x-dev     \
    --working-dir=./src/jbzoo                       \
    --no-update                                     \
    --update-no-dev                                 \
    --no-interaction


echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/jbzoo   \
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
bower update


echo ""
echo ">>> >>> Gulp: Update"
gulp update


echo ""
echo ">>> >>> Webpack"
webpack -v


echo ""
echo ">>> >>> Clean up all!"
find ./src  -name "*.jsx"           -type f -delete
find ./src  -name "*.map"           -type f -delete
find ./src  -name "composer.json"   -type f -delete
find ./src  -name "composer.lock"   -type f -delete
rm   ./src/jbzoo/bin/lessc.bat
rm   ./src/jbzoo/bin/lessc

find ./src                       -type d -empty -delete
