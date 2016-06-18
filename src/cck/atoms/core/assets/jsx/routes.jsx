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

import _ from 'lodash';

module.exports = function configureRoutes(reducerRegistry) {

    var atomList    = ['atoms', 'items'],
        childRoutes = [];

    atomList.map((item) => {
        let cb        = require(`../../../${item}/assets/jsx/routes`).default,
            childItem = cb(reducerRegistry, item);

        if (_.isArray(childItem)) {
            _(childItem).forEach(function (value) {
                childRoutes.push(value);
            });

        } else {
            childRoutes.push(childItem);
        }
    });

    return {
        component  : 'div',
        childRoutes: [
            {
                path       : '/',
                component  : require('./containers/App'),
                childRoutes: Array.prototype.concat(
                    [{indexRoute: {component: require('./pages/Home')}}],
                    childRoutes,
                    [{path: '*', component: require('./pages/NotFound')}]
                )
            }
        ]
    };
};
