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

import fetch from 'isomorphic-fetch'

import {
    ATOMS_LIST_REQUEST,
    ATOMS_LIST_SUCCESS
} from '../defines';


var link = '/administrator/index.php?option=com_jbzoo&ctrl=atoms.index&task=atoms';

function requestAtoms() {
    return {
        type   : ATOMS_LIST_REQUEST,
        payload: false
    }
}

function receiveAtoms(atoms) {
    return {
        type   : ATOMS_LIST_SUCCESS,
        payload: atoms
    }
}

function fetchAtoms() {
    return dispatch => {
        dispatch(requestAtoms());
        dispatch({type: 'LOADER_START'});
        return fetch(link, {credentials: 'same-origin'})
            .then(response => response.json())
            .then(function(json) {
                dispatch({type: 'LOADER_STOP'});
                return dispatch(receiveAtoms(json.list));
            })
    }
}

function shouldFetchAtoms(state) {
    return !state.atoms;
}

export function fetchAtomsIfNeeded() {
    return (dispatch, getState) => {
        if (shouldFetchAtoms(getState())) {
            return dispatch(fetchAtoms())
        }
    }
}
