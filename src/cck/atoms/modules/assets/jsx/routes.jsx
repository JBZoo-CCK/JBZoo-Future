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

var AddApp;
var ModulesApp;

module.exports.default = function (reducerRegistry, atomKey) {

    reducerRegistry.register({
        modules: require('./reducers').modules,
        handleFormButton: require('./reducers').handleFormButton,
        handleFormSend: require('./reducers').handleFormSend
    });

    return [
        {
            path: '/modules',
            getComponent(nextState, callback) {

                if (!ModulesApp) {
                    ModulesApp = require('./components/ModulesApp');
                }

                callback(null, ModulesApp);
            }
        },
        {
            path        : '/modules/add',
            getComponent: (nextState, callback) => {

                if (!AddApp) {
                    AddApp = require('./components/AddApp');
                }

                callback(null, AddApp);
            }
        }
    ]
};
