#!/usr/bin/env sh

ROOT="`pwd`"
JOOMLA="`pwd`/resources/cck-joomla"
WORDPRESS="`pwd`/resources/cck-wordpress"


echo ">>> >>> Composer: Cleanup"
rm -rf ./bin
rm -rf ./vendor
rm -rf ./src/jbzoo/vendor
rm     ./src/jbzoo/composer.lock


echo ""
echo ">>> >>> Composer: Change configs"
composer config bin-dir     "../../bin"     --working-dir=./src/jbzoo
composer config vendor-dir  "../../vendor"  --working-dir=./src/jbzoo


echo ""
echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/jbzoo   \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress


echo ""
echo ">>> >>> Joomla: Create symlinks"
rm -r `$JOOMLA`/plugins/system/jbzoocck
ln -s `$ROOT`/src/joomla-plugins/plg_sys_jbzoocck                           \
      `$JOOMLA`/plugins/system/jbzoocck


rm -r `$JOOMLA`/administrator/components/com_jbzoo
ln -s `$ROOT`/src/joomla-plugins/pkg_jbzoocck/packages/com_jbzoo/admin      \
      `$JOOMLA`/administrator/components/com_jbzoo

rm -r `$JOOMLA`/components/com_jbzoo
ln -s `$ROOT`/src/joomla-plugins/pkg_jbzoocck/packages/com_jbzoo/site       \
      `$JOOMLA`/components/com_jbzoo


echo ""
echo ">>> >>> Wordpress: Create symlinks"
rm -r `$WORDPRESS`/wp-content/plugins/jbzoocck
ln -s `$ROOT`/src/wordpress-plugin/jbzoocck                                 \
      `$WORDPRESS`/wp-content/plugins/jbzoocck
