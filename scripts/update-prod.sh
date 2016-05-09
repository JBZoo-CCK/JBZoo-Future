#!/usr/bin/env sh

echo ">>> >>> Composer"
rm -fr src/jbzoo/vendor

composer config bin-dir bin     \
    --working-dir=src/jbzoo

composer require jbzoo/composer-cleanup:1.x-dev     \
    --no-update                                     \
    --update-no-dev                                 \
    --working-dir=src/jbzoo                         \
    --no-interaction

composer update                 \
    --optimize-autoloader       \
    --no-dev                    \
    --working-dir=src/jbzoo     \
    --no-interaction            \
    --no-progress


echo ""
echo ">>> >>> npm"
rm -fr node_modules
npm install


echo ""
echo ">>> >>> Bower"
rm -fr bower_components
bower update


echo ""
echo ">>> >>> Gulp"
gulp update


echo ""
echo ">>> >>> Webpack"
webpack -v


echo ""
echo ">>> >>> Clean up"
find ./src -name "*.jsx"         -type f -delete
find ./src -name "*.map"         -type f -delete
find ./src -name "composer.json" -type f -delete
find ./src -name "composer.lock" -type f -delete
find ./src                       -type d -empty -delete
rm   ./src/jbzoo/bin/lessc.bat
rm   ./src/jbzoo/bin/lessc
