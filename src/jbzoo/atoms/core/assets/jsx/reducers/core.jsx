/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    CCK
 * @license    Proprietary http://jbzoo.com/license
 * @copyright  Copyright (C) JBZoo.com,  All rights reserved.
 * @link       http://jbzoo.com
 */

'use strict';

import * as defines from '../defines'

module.exports = {
    sidebar  : (state = {}) => state,
    isLoading: function (state = false, action) {

        switch (action.type) {
            case defines.LOADER_START:
                return true;
            case defines.LOADER_STOP:
                return false;
        }

        return state;
    }
};
