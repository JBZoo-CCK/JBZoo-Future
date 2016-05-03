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

import fetch from 'isomorphic-fetch'

var JBZoo = window.JBZOO_INIT !== undefined ? window.JBZOO_INIT : {};

JBZoo = Object.assign({}, {
    defines: {},
    state  : {}
}, JBZoo);


JBZoo.ajax = function (task, data, dispatch, action) {

    if (dispatch) {
        dispatch({type: 'LOADER_START'});
    }

    var noCache = Math.floor(Math.random() * (100000)) + 1;

    return fetch(
        `${JBZoo.defines.AJAX_URL}&act=${task}&nocache=${noCache}`, {
            cache      : 'no-cache',
            credentials: 'same-origin',
            redirect   : 'follow',
            method     : 'POST',
            body       : JSON.stringify(data),
            headers    : {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept'          : 'application/json',
                'Content-Type'    : 'application/json'
            }
        })
        .then(function checkStatus(response) {
            if (response.status >= 200 && response.status < 300) {
                return response;
            } else {
                var error = new Error(response.statusText);
                error.response = response;
                throw error;
            }
        })
        .then(response => response.json())
        .then(function (json) {
            if (dispatch) {
                dispatch({type: 'LOADER_STOP'});
                return dispatch(action(json));
            }

            return json;
        })
        .catch(function (error) {
            if (dispatch) {
                dispatch({type: 'LOADER_STOP'});
                dispatch({type: 'LOADER_STOP_ERROR'});
            }

            if (JBZoo.defines.__DEV__) {
                dump('JBZoo Ajax Error:', error);
            }
        });
};

var _timers = {};

JBZoo.delay = function (handler, delay = 300, timerName = 'default') {
    clearTimeout(_timers[timerName]);
    _timers[timerName] = setTimeout(function () {
        handler();
    }, delay || 1);

    return _timers[timerName];
};


export default JBZoo;
