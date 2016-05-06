#!/usr/bin/env sh

echo ">>> >>> Composer"
rm -fr src/jbzoo/vendor

composer config bin-dir bin     \
    --working-dir=src/jbzoo     \
    --no-interaction

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
