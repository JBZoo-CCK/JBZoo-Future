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
    GET_ATOMS_REQUEST,
    GET_ATOMS_SUCCESS
} from '../defines'

const initialState = {
    atoms   : [],
    fetching: false
};

export default function atoms(state = initialState, action) {

    switch (action.type) {
        case GET_ATOMS_REQUEST:
            return {...state, fetching: true};

        case GET_ATOMS_SUCCESS:
            return {...state, atoms: action.atoms, fetching: false};

        default:
            return state;
    }

}