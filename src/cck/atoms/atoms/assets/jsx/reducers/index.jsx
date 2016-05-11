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

export default function atoms(state = false, action) {

    switch (action.type) {
        case defines.ATOMS_LIST_REQUEST:
        case defines.ATOMS_LIST_SUCCESS:
            return action.payload;

        default:
            return state;
    }
}

export function changeOption(state = false, action) {

    if (action.type == defines.ATOMS_SAVE_STORE) {

        let newState   = Object.assign({}, state),
            paths      = action.payload.name.split('.'),
            atomName   = 'atom.' + paths[0],
            configName = paths[1];

        if (paths.length == 2) {
            newState[atomName][configName] = action.payload.value;
        } else {
            newState[atomName][configName][paths[2]] = action.payload.value;
        }

        return newState;
    }

    return state;
}
