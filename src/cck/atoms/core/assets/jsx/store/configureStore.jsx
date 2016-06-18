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

import * as redux       from 'redux'
import reduxThunk       from 'redux-thunk'
import createLogger     from 'redux-logger'

var configureReducers = require('./configureReducers');

var createStoreWithMiddleware = redux.applyMiddleware(reduxThunk)(redux.createStore);

module.exports = function configureStore(initialState = {}, reducerRegistry) {

    var enhancer;

    if (__DEV__) {
        enhancer = redux.compose(
            redux.applyMiddleware(reduxThunk),
            //redux.applyMiddleware(createLogger()),
            window.devToolsExtension ? window.devToolsExtension() : f => f
        );
    } else {
        enhancer = redux.compose(
            redux.applyMiddleware(reduxThunk)
        );
    }

    var rootReducer = configureReducers(reducerRegistry.getReducers());
    var store       = createStoreWithMiddleware(rootReducer, initialState, enhancer);

    reducerRegistry.setChangeListener((reducers) => {
        store.replaceReducer(configureReducers(reducers))
    });

    return store
};
