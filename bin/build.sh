#!/usr/bin/env sh

echo ">>> >>> Start build extention arch for Joomla!CMS"
SRC_DIR="`pwd`"

echo "Prepare FS"
mkdir -p build/packages

echo "Create symlinks"
if command -v 'cygpath' >/dev/null 2>&1; then
    echo "WARNING!!! Create symlinks manually (by far)"
else
    # General
    # ln -s `pwd`/vendor/                                 src/jbzoo/vendor

    # Joomla
    ln -s `pwd`/src/jbzoo/                              src/joomla-plugins/com_jbzoo/admin/cck
    ln -s `pwd`/src/joomla-plugins/com_jbzoo/           src/joomla-plugins/pkg_jbzoocck/packages/com_jbzoo
    ln -s `pwd`/src/joomla-plugins/plg_sys_jbzoocck/    src/joomla-plugins/pkg_jbzoocck/packages/plg_sys_jbzoocck

    # Wordpress
    ln -s `pwd`/src/jbzoo/                              src/wordpress-plugin/jbzoocck/cck
fi


echo "Comporess Joomla Package"
cd src/joomla-plugins/pkg_jbzoocck
rm  -f  ../../../build/packages/pkg_jbzoocck.zip
zip -rq ../../../build/packages/pkg_jbzoocck.zip *
cd "$SRC_DIR"


echo "Comporess Wordpress Plugin"
cd src/wordpress-plugin/jbzoocck
rm  -f  ../../../build/packages/jbzoocck.zip
zip -rq ../../../build/packages/jbzoocck.zip *
cd "$SRC_DIR"


echo "OK"
