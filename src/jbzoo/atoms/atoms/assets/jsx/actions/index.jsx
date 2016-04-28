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
    GET_ATOMS_REQUEST,
    GET_ATOMS_SUCCESS
} from '../defines';


var link = '/administrator/index.php?option=com_jbzoo&ctrl=atoms.index&task=atoms';

function receiveAtoms(atoms) {
    return {
        type : GET_ATOMS_SUCCESS,
        atoms: atoms.list
    }
}

function requestAtoms() {
    return {
        type : GET_ATOMS_REQUEST,
        atoms: []
    }
}

function fetchAtoms() {
    return dispatch => {
        dispatch(requestAtoms());
        return fetch(link, {credentials: 'same-origin'})
            .then(response => response.json())
            .then(json => dispatch(receiveAtoms(json)))
    }
}

function shouldFetchAtoms(state) {
    if (!state.atoms) {
        return true;
    } else {
        return state.fetching;
    }
}

export function fetchAtomsIfNeeded() {
    return (dispatch, getState) => {
        if (shouldFetchAtoms(getState())) {
            return dispatch(fetchAtoms())
        }
    }
}
