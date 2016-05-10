#!/usr/bin/env sh

echo ">>> >>> Composer: Cleanup"
rm -rf ./src/jbzoo/vendor
rm -rf ./bin
rm     ./src/jbzoo/composer.lock


echo ">>> >>> Composer: Change configs"
composer config bin-dir     "../../bin"     --working-dir=./src/jbzoo
composer config vendor-dir  "../../vendor"  --working-dir=./src/jbzoo


echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/jbzoo   \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress
