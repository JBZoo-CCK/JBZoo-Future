#!/usr/bin/env sh

mkdir -p %wp_path%

echo "## Download"
sh ./bin/wp core download   \
  --path=%wp_path%          \
  --debug

echo "## Core Config"
sh ./bin/wp core config \
  --path=%wp_path%      \
  --dbname=%db_name_wp% \
  --dbuser=%db_user%    \
  --dbpass=%db_pass%    \
  --dbhost=%db_host%    \
  --url="%wp_host%"     \
  --debug

echo "## DB Reset"
sh ./bin/wp db reset    \
  --path=%wp_path%      \
  --yes                 \
  --debug

echo "## Core Install"
sh ./bin/wp core install        \
  --path=%wp_path%              \
  --url="%wp_host%"             \
  --title="JBZoo 3.x-dev"       \
  --admin_user=%admin_login%    \
  --admin_password=%admin_pass% \
  --admin_email=%admin_email%   \
  --debug

echo "## Make dirs"
mkdir -p %wp_path%/cache
mkdir -p %wp_path%/tmp
mkdir -p %wp_path%/logs
