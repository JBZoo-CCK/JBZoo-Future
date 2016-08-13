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
SITE_NAME="cck-joomla"
SITE_WWW="resources"

DB_HOST="127.0.0.1"
if [ "$1" != "" ]; then DB_NAME=$1; else    DB_NAME="ci_jbzoo_j";   fi
if [ "$2" != "" ]; then DB_USER=$2; else    DB_USER="root";         fi
if [ "$3" != "" ]; then DB_PASS=$3; else    DB_PASS="";             fi


echo ""
echo ">>> >>> Joomla: Prepare paths"
mkdir -p $SITE_WWW
sh ./bin/joomla -V


echo ""
echo ">>> >>> Joomla: Database drop"
sh ./bin/joomla                                 \
    database:drop                               \
    $SITE_NAME                                  \
    --www=$SITE_WWW                             \
    --mysql-login=$DB_USER:$DB_PASS             \
    --mysql-host=$DB_HOST                       \
    --mysql-database=$DB_NAME                   \
    -vvv


echo ""
echo ">>> >>> Joomla: Site create"
sh ./bin/joomla                                 \
    site:create                                 \
    $SITE_NAME                                  \
    --www=$SITE_WWW                             \
    --mysql-login=$DB_USER:$DB_PASS             \
    --mysql-host=$DB_HOST                       \
    --mysql-database=$DB_NAME                   \
    -vvv


echo ""
echo ">>> >>> Joomla: Disable debug plugin"
sh ./bin/joomla                                 \
    extension:disable                           \
    $SITE_NAME                                  \
    debug                                       \
    --www=$SITE_WWW                             \
    -vvv


echo ""
echo ">>> >>> Joomla: Disable stats plugin"
sh ./bin/joomla                                 \
    extension:disable                           \
    $SITE_NAME                                  \
    stats                                       \
    --www=$SITE_WWW                             \
    -vvv

echo ""
echo ">>> >>> Joomla: Prepare global config"
php ./scripts/prepare-joomla-config.php


#### JBZoo CCK #########################################################################################################


echo ""
echo ">>> >>> Joomla: Install package"
sh ./bin/joomla                                 \
    extension:installfile                       \
    $SITE_NAME                                  \
    ./build/packages/j_jbzoo.zip                \
    --www=$SITE_WWW                             \
    -vvv


#### Testing ###########################################################################################################


echo ""
echo ">>> >>> Joomla: Install PHPUnit plugin"
sh ./bin/joomla                                 \
    extension:installfile                       \
    $SITE_NAME                                  \
    ./build/packages/j_jbzoophpunit.zip         \
    --www=$SITE_WWW                             \
    -vvv


echo ""
echo ">>> >>> Joomla: Enable PHPUnit plugin"
sh ./bin/joomla                                 \
    extension:enable                            \
    $SITE_NAME                                  \
    jbzoophpunit                                \
    --www=$SITE_WWW                             \
    -vvv

#### Create symlinks ###################################################################################################

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
echo ">>> >>> Extentions for testing"
rm -r "$JOOMLA/plugins/system/jbzoophpunit"
ln -s "$ROOT/tests/extentions/j_jbzoophpunit"                       \
      "$JOOMLA/plugins/system/jbzoophpunit"

