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

function receiveItemAction(item) {

    return {
        type   : defines.ITEMS_ITEM_SUCCESS,
        payload: {
            id  : item.item.id,
            data: item.item
        }
    }
}

function removeItemAction(itemId) {

    return {
        type   : defines.ITEMS_ITEM_REMOVE,
        payload: {
            id: itemId
        }
    }
}

function newItemAction(item) {

    return {
        type   : defines.ITEMS_ITEM_NEW,
        payload: {
            data: item.item
        }
    }
}

function fetchItemAction(itemId) {
    return dispatch => JBZoo.ajax('items.index.getItem', {id: itemId}, dispatch, receiveItemAction);
}

function fetchNewItemAction() {
    return dispatch => JBZoo.ajax('items.index.getNewItem', {}, dispatch, newItemAction);
}

function shouldFetchItem(state, itemId) {
    return !state.items || !state.items[itemId];
}

export function fetchNewItem() {
    return (dispatch, getState) => {
        return dispatch(fetchNewItemAction())
    }
}

export function fetchItemIfNeeded(itemId) {
    return (dispatch, getState) => {
        return dispatch(fetchItemAction(itemId))
    }
}

export function saveItem(item) {
    return (dispatch, getState) => {
        JBZoo.ajax('items.index.saveItem', {item}, dispatch, receiveItemAction);
        return dispatch(receiveItemAction({item}))
    }
}

export function removeItem(itemId) {
    return (dispatch, getState) => {
        JBZoo.ajax('items.index.removeItem', {id: itemId});
        return dispatch(removeItemAction({id: itemId}))
    }
}
