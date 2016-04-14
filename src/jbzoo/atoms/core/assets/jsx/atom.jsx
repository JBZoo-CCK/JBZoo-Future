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

import React from 'react'
import ReactDOM from 'react-dom'

import { Router, hashHistory } from 'react-router'
import { routes } from './routes'
import injectTapEventPlugin from 'react-tap-event-plugin'

import { createStore } from 'redux'
import { Provider } from 'react-redux'
import configureStore from './store/configureStore'

injectTapEventPlugin();

const store = configureStore();

ReactDOM.render(
    <Provider store={store}>
        <Router history={hashHistory} routes={routes} />
    </Provider>,
    document.getElementById('jbzoo-react-app')
);
