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

import { injectAsyncReducer } from '../../../core/assets/jsx/store/configureStore';

module.exports.default = function (reducerRegistry, atomKey) {
    return {
        path: 'atoms',
        getComponent(nextState, callback) {

            let addObj = {};
            addObj[atomKey] = require('./reducers/atoms');
            reducerRegistry.register(addObj);

            callback(null, require('./AtomsApp'));
        }
    }
};
