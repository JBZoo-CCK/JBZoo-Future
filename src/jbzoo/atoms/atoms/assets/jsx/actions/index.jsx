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

import JBZoo        from '../../../../../assets/jsx/Globals';
import * as defines from '../defines';

function requestAtoms() {
    return {
        type   : defines.ATOMS_LIST_REQUEST,
        payload: false
    }
}

function receiveAtoms(atoms) {
    return {
        type   : defines.ATOMS_LIST_SUCCESS,
        payload: atoms.list
    }
}

function saveOptionReceive() {
    return {
        type   : defines.ATOMS_SAVE_OPTION,
        payload: true
    }
}

function fetchAtoms() {
    return dispatch => JBZoo.ajax('atoms.index.getConfigForms', {}, dispatch, receiveAtoms);
}

function saveAtomOption(name, newValue) {
    let data = {
        name : name,
        value: newValue
    };

    return function (dispatch) {
        dispatch({
            type   : defines.ATOMS_SAVE_STORE,
            payload: data
        });

        return JBZoo.ajax('atoms.index.saveOption', data, dispatch, saveOptionReceive)
    };
}

function shouldFetchAtoms(state) {
    return !state.atomsForms;
}

export function fetchAtomsIfNeeded() {
    return (dispatch, getState) => {
        if (shouldFetchAtoms(getState())) {
            return dispatch(fetchAtoms())
        }
    }
}

export function onOptionChange(name, newValue) {
    return (dispatch, getState) => {
        return dispatch(saveAtomOption(name, newValue))
    }
}
