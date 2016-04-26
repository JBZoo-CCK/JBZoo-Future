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

import { createStore, applyMiddleware, compose } from 'redux'
import reduxThunk   from 'redux-thunk'
import rootReducer  from '../reducers'

export default function configureStore(initialState = {}) {

    var enhancer = compose(
        applyMiddleware(reduxThunk)
    );

    if (__DEV__) {
        enhancer = compose(
            applyMiddleware(reduxThunk),
            window.devToolsExtension ? window.devToolsExtension() : f => f
        );
    }

    initialState.fetching = false;

    return createStore(rootReducer, initialState, enhancer);
}
