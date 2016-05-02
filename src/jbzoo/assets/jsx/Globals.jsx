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
    defines  : {},
    initState: {}
}, JBZoo);


JBZoo.ajax = function (task, data, dispatch, action) {

    dispatch({type: 'LOADER_START'});

    data.act = task;

    return fetch(
        `${JBZoo.defines.AJAX_URL}&act=${task}`, {
            cache      : 'no-cache',
            credentials: 'same-origin',
            redirect   : 'follow',
            method     : 'POST',
            body       : data
        })
        .then(response => response.json())
        .then(function (json) {
            dispatch({type: 'LOADER_STOP'});
            return dispatch(action(json));
        })
        .catch(function (error) {
            dispatch({type: 'LOADER_STOP'});
            dispatch({type: 'LOADER_STOP_ERROR'});
            console.log('JBZoo Ajax Error:', error);
        });
};

export default JBZoo;
