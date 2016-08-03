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

CMS_DIR=$1
HTTP_HOST=$2
HTTP_PORT=$3

WEB_ROOT="./resources/$CMS_DIR"
WEB_INDEX="./resources/$CMS_DIR/index.php"

php -S "$HTTP_HOST:$HTTP_PORT" -t "$WEB_ROOT" "$WEB_INDEX" &

sleep 3s
