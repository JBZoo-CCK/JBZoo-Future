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

SRC_DIR="`pwd`"

echo ""
echo "Prepare FS"
mkdir -p build/packages


echo ""
echo "Create symlinks"
if command -v 'cygpath' >/dev/null 2>&1; then
    echo "WARNING!!! Create symlinks manually (by far)"
else
    # Joomla
    mkdir -p    src/joomla-plugins/pkg_jbzoocck/packages
    ln -s `pwd`/src/jbzoo/                              src/joomla-plugins/com_jbzoo/admin/cck
    ln -s `pwd`/src/joomla-plugins/com_jbzoo/           src/joomla-plugins/pkg_jbzoocck/packages/com_jbzoo
    ln -s `pwd`/src/joomla-plugins/plg_sys_jbzoocck/    src/joomla-plugins/pkg_jbzoocck/packages/plg_sys_jbzoocck

    # Wordpress
    ln -s `pwd`/src/jbzoo/                              src/wordpress-plugin/jbzoocck/cck
fi


#### JBZoo CCK #########################################################################################################


echo ""
echo "Compress: Joomla Package"
cd src/joomla-plugins/pkg_jbzoocck
rm  -f  ../../../build/packages/pkg_jbzoocck.zip
zip -rq ../../../build/packages/pkg_jbzoocck.zip *
cd "$SRC_DIR"


echo ""
echo "Compress: Wordpress Plugin"
cd src/wordpress-plugin/jbzoocck
rm  -f  ../../../build/packages/jbzoocck.zip
zip -rq ../../../build/packages/jbzoocck.zip *
cd "$SRC_DIR"


#### Testing ###########################################################################################################


echo ""
echo "Compress: Joomla PHPUnit plugin"
cd tests/extentions/joomla-plugin
rm  -f  ../../../build/packages/plg_jbzoophpunit.zip
zip -rq ../../../build/packages/plg_jbzoophpunit.zip *
cd "$SRC_DIR"


echo ""
echo "Compress: Wordpress PHPUnit plugin"
cd tests/extentions/wp-plugin
rm  -f  ../../../build/packages/jbzoophpunit.zip
zip -rq ../../../build/packages/jbzoophpunit.zip *
cd "$SRC_DIR"

ls -lAhv ./build/packages
