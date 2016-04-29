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
    ATOMS_LIST_REQUEST,
    ATOMS_LIST_SUCCESS
} from '../defines'

export default function atoms(state = false, action) {

    switch (action.type) {
        case ATOMS_LIST_REQUEST:
        case ATOMS_LIST_SUCCESS:
            return action.payload;

        default:
            return state;
    }
}
