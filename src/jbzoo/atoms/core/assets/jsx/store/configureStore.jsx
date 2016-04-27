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

import * as redux       from 'redux'
import reduxThunk       from 'redux-thunk'
import createReducer    from '../reducers/createReducer'

var configureReducers = require('./configureReducers');

var createStoreWithMiddleware = redux.applyMiddleware(reduxThunk)(redux.createStore);

module.exports = function configureStore(initialState = {}, reducerRegistry) {

    var enhancer = redux.compose(
        redux.applyMiddleware(reduxThunk)
    );

    if (__DEV__) {
        enhancer = redux.compose(
            redux.applyMiddleware(reduxThunk),
            window.devToolsExtension ? window.devToolsExtension() : f => f
        );
    }

    var rootReducer = configureReducers(reducerRegistry.getReducers());

    var store       = createStoreWithMiddleware(rootReducer, initialState, enhancer);

    reducerRegistry.setChangeListener((reducers) => {
        store.replaceReducer(configureReducers(reducers))
    });

    return store
};

/*
export default function configureStore(initialState = {}) {
    var enhancer = redux.compose(
        redux.applyMiddleware(reduxThunk)
    );



    let store = redux.createStore(createReducer(), initialState, enhancer);

    return store;
}
*/
