#!/usr/bin/env sh

echo ">>> >>> Change vendor path"
rm -r ./src/jbzoo/vendor
rm ./src/jbzoo/composer.lock
mv ./src/jbzoo/composer.json    ./composer.json

composer config bin-dir bin

composer install                \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress
