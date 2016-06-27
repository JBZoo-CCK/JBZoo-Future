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

        default:
            return state;
    }

}

const handleFormButtonState = {
    canSubmit: false
};

export function handleFormButton(state = handleFormButtonState, action)
{
    switch (action.type) {

        case defines.DISABLE_FORM_BUTTON:
            return {...state, ...{canSubmit: false}};
        break;

        case defines.ENABLE_FORM_BUTTON:
            return {...state, ...{canSubmit: true}};
        break;

        default:
            return state;
    }
}

const handleForm = {
    type : defines.DEFAULT_FORM_STATE
};

export function handleFormSend(state = handleForm, action)
{
    switch (action.type) {

        case defines.ON_ADD_SUCCESS:
            return {...state, ...{type: defines.ON_ADD_SUCCESS}};
        break;

        default:
            return state;
    }
}
