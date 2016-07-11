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

var ModuleAdd, ModuleList, ModuleEdit;

module.exports.default = function (reducerRegistry, atomKey) {

    reducerRegistry.register({
        modules: require('./reducers').modules
    });

    return [
        {
            path: '/modules',
            getComponent(nextState, callback) {

                if (!ModuleList) {
                    ModuleList = require('./components/ModuleList');
                }

                callback(null, ModuleList);
            }
        },
        {
            path        : '/modules/add',
            getComponent: (nextState, callback) => {

                if (!ModuleAdd) {
                    ModuleAdd = require('./components/ModuleAdd');
                }

                callback(null, ModuleAdd);
            }
        },
        {
            path        : '/modules/edit/:id',
            getComponent: (nextState, callback) => {

                if (!ModuleEdit) {
                    ModuleEdit = require('./components/ModuleEdit');
                }

                callback(null, ModuleEdit);
            }
        }
    ]
};
