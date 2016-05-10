#!/usr/bin/env sh

SITE_NAME="cck-joomla"
PATH_WWW="resources"

DB_HOST="127.0.0.1"
if [ "$1" != "" ]; then DB_NAME=$1; else    DB_NAME="ci_jbzoo_wp";  fi
if [ "$2" != "" ]; then DB_USER=$2; else    DB_USER="root";         fi
if [ "$3" != "" ]; then DB_PASS=$3; else    DB_PASS="";             fi


echo ""
echo ">>> >>> Joomla: Prepare paths"
mkdir -p $PATH_WWW
sh ./bin/joomla -V


echo ""
echo ">>> >>> Joomla: Database drop"
sh ./bin/joomla                                 \
    database:drop                               \
    $SITE_NAME                                  \
    --www=$PATH_WWW                             \
    --mysql-login=$DB_USER:$DB_PASS             \
    --mysql-host=$DB_HOST                       \
    --mysql-database=$DB_NAME                   \
    -vvv


echo ""
echo ">>> >>> Joomla: Site create"
sh ./bin/joomla                                 \
    site:create                                 \
    $SITE_NAME                                  \
    --www=$PATH_WWW                             \
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
    --www=$PATH_WWW                             \
    -vvv


echo ""
echo ">>> >>> Joomla: Disable stats plugin"
sh ./bin/joomla                                 \
    extension:disable                           \
    $SITE_NAME                                  \
    stats                                       \
    --www=$PATH_WWW                             \
    -vvv


echo ""
echo ">>> >>> Joomla: Install package"
sh ./bin/joomla                                 \
    extension:installfile                       \
    $SITE_NAME                                  \
    ./build/packages/pkg_jbzoocck.zip           \
    --www=$PATH_WWW                             \
    -vvv


#### Testing ###########################################################################################################


echo ""
echo ">>> >>> Joomla: Install PHPUnit plugin"
sh ./bin/joomla                                 \
    extension:installfile                       \
    $SITE_NAME                                  \
    ./build/packages/plg_jbzoophpunit.zip       \
    --www=$PATH_WWW                             \
    -vvv


echo ""
echo ">>> >>> Joomla: Enable PHPUnit plugin"
sh ./bin/joomla                                 \
    extension:enable                            \
    $SITE_NAME                                  \
    jbzoophpunit                                \
    --www=$PATH_WWW                             \
    -vvv
