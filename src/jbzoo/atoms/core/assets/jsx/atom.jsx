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

import React                from 'react'
import ReactDOM             from 'react-dom'
import injectTapEventPlugin from 'react-tap-event-plugin'
import { Provider }         from 'react-redux'
import { Router, hashHistory }  from 'react-router'

import initialState         from './store/initialState'
import configureStore       from './store/configureStore'

var configureRoutes = require('./routes');
var ReducerRegistry = require('./store/ReducerRegistry');
var coreReducers    = require('./reducers/core');

// Prepare store
var reducerRegister = new ReducerRegistry(coreReducers);
var routes = configureRoutes(reducerRegister);
var store = configureStore(initialState, reducerRegister);


// Global hacks
injectTapEventPlugin();
jQuery('html').addClass('jbzoo-wp-admin');

ReactDOM.render(
    <Provider store={store}>
        <Router history={hashHistory} routes={routes} />
    </Provider>,
    document.getElementById('jbzoo-app')
);
