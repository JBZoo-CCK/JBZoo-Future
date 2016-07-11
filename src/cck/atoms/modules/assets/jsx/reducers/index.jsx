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

export function modules(state = [], action) {

    switch (action.type) {

        case defines.MODULE_LIST:
            return action.payload;

        case defines.MODULE_REMOVE:
            let newState = {...state};
            if (action.payload.id > 0 && newState[action.payload.id]) {
                delete newState[action.payload.id];
            }
            return newState;

        case defines.MODULE_ADD:
        case defines.MODULE_EDIT:
            let addState = {...state};
            if (action.payload.id > 0 && addState[action.payload.id]) {
                addState[action.payload.id] = action.payload;
            }
            return addState;

        default:
            return state;
    }

}
