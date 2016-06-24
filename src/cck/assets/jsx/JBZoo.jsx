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


JBZoo.ajax = function (task, data = {}, storeDispatch, storeAction) {

    if (storeDispatch) {
        storeDispatch({type: 'LOADER_START'});
    }

    var noCacheParam = Math.floor(Math.random() * 100000) + 1,
        ajaxUrl      = `${JBZoo.defines.AJAX_URL}&nocache=${noCacheParam}&act=${task}`,
        errorHandler = function (error) {

            if (storeDispatch) {
                storeDispatch({type: 'LOADER_STOP'});
                storeDispatch({type: 'LOADER_STOP_ERROR'});
            }

            if (JBZoo.defines.__DEV__) {
                dump(error, 'JBZoo Ajax Error');
            }
        };

    return fetch(
        ajaxUrl,
        {
            cache      : 'no-cache',
            credentials: 'same-origin',
            redirect   : 'follow',
            method     : 'POST',
            body       : JSON.stringify(data),
            headers    : {
                'X-Requested-With': 'XMLHttpRequest',
                'X-XSRF-Token'    : window.JBZooVars.csrf,
                'Accept'          : 'application/json',
                'Content-Type'    : 'application/json'
            }
        })
        .then(function (response) {
            if (response.status >= 200 && response.status < 300) {
                return response;
            } else {
                var error = new Error(response.statusText);
                error.response = response;
                throw error;
            }
        })
        .then(function (response) {

            var contentType = response.headers.get('Content-Type');

            if (contentType.indexOf('application/json;') === 0) {

                return response.json()
                    .then(function (json) {

                        if (storeDispatch) {
                            storeDispatch({type: 'LOADER_STOP'});
                            if (storeAction) {
                                return storeDispatch(storeAction(json));
                            }
                        }

                        return json;
                    });
            }

            return response.text();
        })
        .catch(errorHandler);
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
