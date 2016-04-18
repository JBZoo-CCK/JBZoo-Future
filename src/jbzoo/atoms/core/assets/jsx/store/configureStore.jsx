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
import rootReducer from '../reducers'
import createLogger from 'redux-logger'
import thunk from 'redux-thunk'
import devTools from 'remote-redux-devtools';

export default function configureStore(initialState) {

    const enhancer = compose(
        applyMiddleware(thunk)
    );

    if (__DEV__) {
        const logger = createLogger();
        const enhancer = compose(
            applyMiddleware(thunk, logger),
            devTools()
        );
    }

    return createStore(rootReducer, initialState, enhancer);
}
