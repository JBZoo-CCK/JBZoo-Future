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

import App from './containers/App'
import Home from './components/Home'
import NotFound from './components/NotFound'

export const routes = {
    component  : 'div',
    childRoutes: [
        {
            path       : '/',
            component  : App,
            childRoutes: [
                {
                    indexRoute: {component: Home}
                },
                {
                    path     : '*',
                    component: NotFound
                }
            ]
        }
    ]
};
