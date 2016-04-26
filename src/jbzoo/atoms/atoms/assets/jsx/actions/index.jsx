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
    GET_ATOMS_REQUEST,
    GET_ATOMS_SUCCESS
} from '../defines';

export function getAtoms() {

    return (dispatch) => {
        dispatch({
            type   : GET_ATOMS_REQUEST,
            payload: []
        });

        setTimeout(() => {
            dispatch({
                type   : GET_ATOMS_SUCCESS,
                payload: [1, 2, 3, 4, 5]
            })
        }, 5000);
    }
}