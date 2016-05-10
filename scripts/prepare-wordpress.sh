#!/usr/bin/env sh

SITE_WWW="resources/cck-wordpress"
SITE_HOST="cck-wordpress.jbzoo"
SITE_NAME="JBZoo 3.x-dev"

ADMIN_LOGIN="admin"
ADMIN_PASS="admin"
ADMIN_EMAIL="admin@example.ru"

DB_HOST="127.0.0.1"
if [ "$1" != "" ];  then DB_NAME=$1; else    DB_NAME="ci_jbzoo_wp";  fi
if [ "$2" != "" ];  then DB_USER=$2; else    DB_USER="root";         fi
if [ "$3" != "" ];  then DB_PASS=$3; else    DB_PASS="";             fi


echo ""
echo ">>> >>> Wordpress: Prepare paths"
mkdir -p $SITE_WWW
mkdir -p $SITE_WWW/cache
mkdir -p $SITE_WWW/tmp
mkdir -p $SITE_WWW/logs


echo ""
echo ">>> >>> Wordpress: Download"
sh ./bin/wp                             \
    core download                       \
    --version=4.5.1                     \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: Core Config"
sh ./bin/wp                             \
    core config                         \
    --dbname=$DB_NAME                   \
    --dbuser=$DB_USER                   \
    --dbpass=$DB_PASS                   \
    --dbhost=$DB_HOST                   \
    --url="$SITE_HOST"                  \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: DB Reset"
sh ./bin/wp                             \
    db reset                            \
    --yes                               \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: Core Install"
sh ./bin/wp                             \
    core install                        \
    --url="$SITE_HOST"                  \
    --title="$SITE_NAME"                \
    --admin_user=$ADMIN_LOGIN           \
    --admin_password=$ADMIN_PASS        \
    --admin_email=$ADMIN_EMAIL          \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: Install JBZoo"
sh ./bin/wp                             \
    plugin install                      \
    ./build/packages/jbzoocck.zip       \
    --force                             \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: Activate JBZoo"
sh ./bin/wp                             \
    plugin activate jbzoocck            \
    --path=$SITE_WWW                    \
    --debug


#### Testing ###########################################################################################################


echo ""
echo ">>> >>> Wordpress: Install PHPUnit plugin"
sh ./bin/wp                             \
    plugin install                      \
    ./build/packages/jbzoophpunit.zip   \
    --force                             \
    --path=$SITE_WWW                    \
    --debug


echo ""
echo ">>> >>> Wordpress: Activate PHPUnit plugin"
sh ./bin/wp                             \
    plugin activate jbzoophpunit        \
    --path=$SITE_WWW                    \
    --debug
