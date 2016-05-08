#!/usr/bin/env sh

echo ">>> >>> Change vendor path"
rm -rf src/jbzoo/vendor
rm -rf bin
rm     src/jbzoo/composer.lock

composer config vendor-dir "../../vendor" \
    --working-dir=src/jbzoo


composer config bin-dir "../../bin" \
    --working-dir=src/jbzoo


composer update                 \
    --optimize-autoloader       \
    --working-dir=src/jbzoo     \
    --no-interaction
