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
    mkdir -p    src/joomla/pkg_jbzoocck/packages
    ln -s `pwd`/src/jbzoo/                          src/joomla/com_jbzoo/admin/cck
    ln -s `pwd`/src/joomla/com_jbzoo/               src/joomla/pkg_jbzoocck/packages/com_jbzoo
    ln -s `pwd`/src/joomla/plg_sys_jbzoocck/        src/joomla/pkg_jbzoocck/packages/plg_sys_jbzoocck

    # Wordpress
    ln -s `pwd`/src/jbzoo/                          src/wordpress/jbzoo/cck
fi


#### JBZoo CCK #########################################################################################################


echo ""
echo "Compress: Joomla Package"
cd src/joomla/pkg_jbzoocck
rm  -f  ../../../build/packages/j_jbzoo.zip
zip -rq ../../../build/packages/j_jbzoo.zip *
cd "$SRC_DIR"


echo ""
echo "Compress: Wordpress Plugin"
cd src/wordpress/jbzoo
rm  -f  ../../../build/packages/wp_jbzoo.zip
zip -rq ../../../build/packages/wp_jbzoo.zip *
cd "$SRC_DIR"


#### Testing ###########################################################################################################


echo ""
echo "Compress: Joomla PHPUnit plugin"
cd tests/extentions/joomla-plugin
rm  -f  ../../../build/packages/j_jbzoophpunit.zip
zip -rq ../../../build/packages/j_jbzoophpunit.zip *
cd "$SRC_DIR"


echo ""
echo "Compress: Wordpress PHPUnit plugin"
cd tests/extentions/wp-plugin
rm  -f  ../../../build/packages/wp_jbzoophpunit.zip
zip -rq ../../../build/packages/wp_jbzoophpunit.zip *
cd "$SRC_DIR"

ls -lAhv ./build/packages
