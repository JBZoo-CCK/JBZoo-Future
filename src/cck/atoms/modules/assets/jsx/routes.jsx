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

var ModulesApp;

module.exports.default = function (reducerRegistry, atomKey) {

    reducerRegistry.register({
        modules : require('./reducers').modules
    });

    return {
        path: '/modules',
        getComponent(nextState, callback) {

            if (!ModulesApp) {
                ModulesApp = require('./ModulesApp');
            }

            callback(null, ModulesApp);
        }
    }
};
