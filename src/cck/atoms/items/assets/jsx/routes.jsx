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

import { injectAsyncReducer } from '../../../core/assets/jsx/store/configureStore';

var ItemList;
var EditItem;
var EditPositions;

module.exports.default = function (reducerRegistry, atomKey) {

    reducerRegistry.register({
        items   : require('./reducers').items,
        elements: require('./reducers').elements
    });

    return [
        {
            path        : '/items',
            getComponent: (nextState, callback) => {

                if (!ItemList) {
                    ItemList = require('./components/ItemList');
                }

                callback(null, ItemList);
            }
        },
        {
            path        : '/items/edit-positions',
            getComponent: (nextState, callback) => {

                if (!EditPositions) {
                    EditPositions = require('./components/EditPositions');
                }

                callback(null, EditPositions);
            }
        },
        {
            path        : '/items/edit/:id',
            getComponent: (nextState, callback) => {

                if (!EditItem) {
                    EditItem = require('./components/EditItem');
                }

                callback(null, EditItem);
            }
        }
    ]
};
