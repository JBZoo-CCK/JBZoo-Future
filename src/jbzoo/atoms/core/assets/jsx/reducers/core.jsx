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

import {
    LOADER_START,
    LOADER_STOP
} from '../defines'

module.exports = {
    sidebar  : (state = {}) => state,
    isLoading: function (state = false, action) {

        switch (action.type) {
            case LOADER_START:
                return true;
            case LOADER_STOP:
                return false;
        }

        return state;
    }
};
