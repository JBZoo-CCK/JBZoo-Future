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

echo ""
echo ">>> >>> GIT"
git reset --hard


echo ""
echo ">>> >>> Remove dirs"
rm -fr ./bin
rm -fr ./vendor
rm -fr ./node_modules
rm -fr ./src/jbzoo/vendor
rm -fr ./bower_components
