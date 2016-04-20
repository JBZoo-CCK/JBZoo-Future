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

import { routes as initRoutes } from './store/initialState'

var atomList    = ['atoms'],
    childRoutes = [];


atomList.map((item) => {
    childRoutes.push(require(`../../../${item}/assets/jsx/routes`));
});


__webpack_public_path__ = (function () {
    return '/asdasdasd/';
}());

export const routes = {
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
