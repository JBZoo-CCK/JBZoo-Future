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
import JBZoo            from '../../../../../assets/jsx/JBZoo';

function handleAddModule(data) {
    return {
        type    : defines.MODULE_ADD,
        payload : data.module
    };
}

function onAddModule(data) {
    return dispatch => JBZoo.ajax('modules.index.add', data, dispatch, handleAddModule);
}

export function addModule(data) {
    let module = {module: data};
    return (dispatch, getState) => {
        dispatch(onAddModule(module));
    }
}

function handleUpdateModule(data) {
    return {
        type    : defines.MODULE_EDIT,
        payload : data.module
    };
}

function onUpdateModule(data) {
    return dispatch => JBZoo.ajax('modules.index.update', data, dispatch, handleUpdateModule);
}

export function updateModule(data) {
    let module = {module: data};
    return (dispatch, getState) => {
        dispatch(onUpdateModule(module));
    }
}

function handleRemoveModule(data) {
    return {
        type    : defines.MODULE_REMOVE,
        payload : data.removed
    }
}

function onDeleteModule(moduleId) {
    return dispatch => JBZoo.ajax('modules.index.remove', {id: moduleId}, dispatch, handleRemoveModule);
}

export function removeModule(moduleId) {
    return (dispatch, getState) => {
        dispatch(onDeleteModule(moduleId));
    }
}
