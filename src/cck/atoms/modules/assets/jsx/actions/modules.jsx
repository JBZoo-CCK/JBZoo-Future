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

import JBZoo        from '../../../../../assets/jsx/JBZoo';
import * as defines from '../defines';

function receiveModules(modules) {
    return {
        type    : defines.MODULE_LIST,
        payload : modules.list
    }
}

function fetchModules() {
    return dispatch => JBZoo.ajax('modules.index.index', {}, dispatch, receiveModules);
}

export function fetchModulesIfNeeded() {
    return (dispatch, getState) => {
        return dispatch(fetchModules())
    }
}
