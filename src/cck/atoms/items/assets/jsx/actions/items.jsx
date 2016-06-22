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

function receiveItems(items) {
    return {
        type   : defines.ITEMS_LIST_SUCCESS,
        payload: items.list
    }
}

function fetchItems() {
    return dispatch => JBZoo.ajax('items.index.getList', {}, dispatch, receiveItems);
}

function shouldFetchItems(state) {
    return state.items.length == 0;
}

export function fetchItemsIfNeeded() {
    return (dispatch, getState) => {
        return dispatch(fetchItems())
    }
}
