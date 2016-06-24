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

import JBZoo        from '../../../../../assets/jsx/JBZoo';
import * as defines from '../defines';
import { hashHistory } from 'react-router'

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

function onSubmit(module) {
    return {
        type: (module.id) ? defines.ON_SUBMIT_SUCCESS : defines.ON_SUBMIT_FAIL
    }
}

function fetchModule(data) {
    return dispatch => JBZoo.ajax('modules.index.add', data, dispatch, onSubmit);
}

export function submitForm(data) {
    let module = {
        data: JSON.stringify(data)
    };
    return (dispatch, getState) => {
        dispatch(fetchModule(module));
        hashHistory.push('/modules');
    }
}
