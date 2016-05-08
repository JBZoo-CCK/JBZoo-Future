#!/usr/bin/env sh

echo ">>> >>> Change vendor path"
rm -r ./src/jbzoo/vendor
rm    ./src/jbzoo/composer.lock

composer config vendor-dir "../../vendor"

composer install                \
    --optimize-autoloader       \
    --working-dir=src/jbzoo     \
    --no-interaction            \
    --no-progress
