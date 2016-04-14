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

import {
    GET_PHOTOS_REQUEST,
    GET_PHOTOS_SUCCESS
} from '../constants/Page'


export function setYear(year) {

    return {
        type   : 'SET_YEAR',
        payload: year
    }
}

export function getPhotos(year) {

    return (dispatch) => {
        dispatch({
            type   : GET_PHOTOS_REQUEST,
            payload: year
        });

        setTimeout(() => {
            dispatch({
                type   : GET_PHOTOS_SUCCESS,
                payload: [1, 2, 3, 4, 5]
            })
        }, 1000)
    }
}
