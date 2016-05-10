#!/usr/bin/env sh

echo ">>> >>> Composer: Cleanup"
rm -fr ./bin
rm -fr ./vendor
rm -fr ./src/jbzoo/vendor


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
./node_modules/.bin/bower update


echo ""
echo ">>> >>> Gulp: Update"
./node_modules/.bin/gulp update


echo ""
echo ">>> >>> Webpack"
./node_modules/.bin/webpack -v


echo ""
echo ">>> >>> Clean up all!"
rm   ./src/jbzoo/bin/lessc.bat
rm   ./src/jbzoo/bin/lessc
find ./src  -name "*.jsx"           -type f -delete
find ./src  -name "*.map"           -type f -delete
find ./src  -name "composer.json"   -type f -delete
find ./src  -name "composer.lock"   -type f -delete
find ./src                          -type d -empty -delete
