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

function receiveItem(item) {

    return {
        type   : defines.ITEMS_ITEM_SUCCESS,
        payload: {
            id  : item.item.id,
            data: item.item
        }
    }
}

function fetchItem(itemId) {
    return dispatch => JBZoo.ajax('items.index.getItem', {id: itemId}, dispatch, receiveItem);
}

function shouldFetchItem(state, itemId) {
    return !state.items || !state.items[itemId];
}

export function fetchItemIfNeeded(itemId) {
    return (dispatch, getState) => {
        return dispatch(fetchItem(itemId))
    }
}
