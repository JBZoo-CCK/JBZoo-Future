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

import * as defines     from '../defines';
import { hashHistory }  from 'react-router'
import JBZoo            from '../../../../../assets/jsx/JBZoo';

export function enableButtons() {
    return (dispatch, getState) => {
        return dispatch({
            type: defines.ENABLE_FORM_BUTTON,
            canSubmit: true
        })
    }
}

export function disableButtons() {
    return (dispatch, getState) => {
        return dispatch({
            type: defines.DISABLE_FORM_BUTTON,
            canSubmit: false
        })
    }
}

function handleAddModule() {
    return {
        type: defines.ON_ADD_SUCCESS
    };
}

function onAddModule(data) {
    return dispatch => JBZoo.ajax('modules.index.add', data, dispatch, handleAddModule);
}

export function addModule(data) {
    let module = {
        data: JSON.stringify(data)
    };
    return (dispatch, getState) => {
        dispatch(onAddModule(module));
        hashHistory.push('/modules');
    }
}

function handleUpdateModule() {
    return {
        type: defines.ON_UPDATE_SUCCESS
    };
}

function onUpdateModule(data) {
    return dispatch => JBZoo.ajax('modules.index.update', data, dispatch, handleUpdateModule);
}

export function updateModule(data) {
    let module = {
        data: JSON.stringify(data)
    };
    return (dispatch, getState) => {
        dispatch(onUpdateModule(module));
        hashHistory.push('/modules');
    }
}