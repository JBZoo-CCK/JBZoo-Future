#!/usr/bin/env sh

echo "- - -"
echo "-= Check ALL =- "
echo "- - -"

rm -fr ./bower_components
NODE_ENV=development ./node_modules/.bin/bower  update
NODE_ENV=development ./node_modules/.bin/gulp   update
NODE_ENV=development ./node_modules/.bin/webpack -v
./node_modules/.bin/webpack -v
