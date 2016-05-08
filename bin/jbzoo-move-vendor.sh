#!/usr/bin/env sh

echo ">>> >>> Change vendor path"
rm -rf src/jbzoo/vendor
rm     src/jbzoo/composer.lock

composer config vendor-dir "../../vendor" \
    --working-dir=src/jbzoo


composer install                \
    --optimize-autoloader       \
    --working-dir=src/jbzoo     \
    --no-interaction            \
    --no-progress
