#!/usr/bin/env sh

#
# JBZoo CCK
#
# This file is part of the JBZoo CCK package.
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @package   CCK
# @license   Proprietary http://jbzoo.com/license
# @copyright Copyright (C) JBZoo.com,  All rights reserved.
# @link      http://jbzoo.com
#

ROOT="`pwd`"
JOOMLA="`pwd`/resources/cck-joomla"
WORDPRESS="`pwd`/resources/cck-wordpress"


echo ">>> >>> Composer: Cleanup"
rm -rf ./bin
rm -rf ./vendor
rm -rf ./src/cck/vendor
rm     ./src/cck/composer.lock


echo ""
echo ">>> >>> Composer: Change configs"
composer config bin-dir     "../../bin"     --working-dir=./src/cck
composer config vendor-dir  "../../vendor"  --working-dir=./src/cck


echo ""
echo ">>> >>> Composer: Update"
composer update                 \
    --working-dir=./src/cck     \
    --optimize-autoloader       \
    --no-interaction            \
    --no-progress


if command -v 'cygpath' >/dev/null 2>&1; then
    echo "WARNING!!! Create symlinks manually (by far)"
else
    echo ""
    echo ">>> >>> Joomla: Create symlinks"
    rm -r "$JOOMLA/plugins/system/jbzoocck"
    ln -s "$ROOT/src/joomla/plg_sys_jbzoocck"                           \
          "$JOOMLA/plugins/system/jbzoocck"

    rm -r "$JOOMLA/administrator/components/com_jbzoo"
    ln -s "$ROOT/src/joomla/pkg_jbzoocck/packages/com_jbzoo/admin"      \
          "$JOOMLA/administrator/components/com_jbzoo"

    rm -r "$JOOMLA/components/com_jbzoo"
    ln -s "$ROOT/src/joomla/pkg_jbzoocck/packages/com_jbzoo/site"       \
          "$JOOMLA/components/com_jbzoo"


    echo ""
    echo ">>> >>> Wordpress: Create symlinks"
    rm -r "$WORDPRESS/wp-content/plugins/jbzoo"
    ln -s "$ROOT/src/wordpress/jbzoo"                                   \
          "$WORDPRESS/wp-content/plugins/jbzoo"


    echo ""
    echo ">>> >>> Extentions for testing"
    rm -r "$JOOMLA/plugins/system/jbzoophpunit"
    ln -s "$ROOT/tests/extentions/j_jbzoophpunit"                       \
          "$JOOMLA/plugins/system/jbzoophpunit"

    rm -r "$WORDPRESS/wp-content/plugins/wp_jbzoophpunit"
    ln -s "$ROOT/tests/extentions/wp_jbzoophpunit"                      \
          "$WORDPRESS/wp-content/plugins/wp_jbzoophpunit"
fi
