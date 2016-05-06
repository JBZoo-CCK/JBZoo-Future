#!/usr/bin/env sh

mkdir -p resources

echo "## Database drop"
sh ./bin/joomla     database:drop cck-joomla    \
    --www=%joomla_path%                         \
    --mysql-login=%db_user%:%db_pass%           \
    --mysql-host=%db_host%                      \
    --mysql-database=%db_name_j%                \
    --verbose

echo "## Site create"
sh ./bin/joomla     site:create cck-joomla        \
    --www=%joomla_path%                           \
    --mysql-login=%db_user%:%db_pass%             \
    --mysql-host=%db_host%                        \
    --mysql-database=%db_name_j%                  \
    --verbose

echo "## Disable debug plugin"
sh ./bin/joomla extension:disable cck-joomla debug  \
    --www=%joomla_path%                             \
    --verbose
