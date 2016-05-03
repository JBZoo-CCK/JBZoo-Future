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

        let paths = action.payload.name.split('.');
        let atomConfigName = 'atom.' + paths[0];

        let subConfig = {};
        subConfig[atomConfigName] = Object.assign({}, state[atomConfigName]);
        subConfig[atomConfigName][paths[1]] = action.payload.value;

        return Object.assign({}, state, subConfig);
    }

    return state;
}
