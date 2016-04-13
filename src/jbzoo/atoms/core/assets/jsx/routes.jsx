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

import React from 'react'
import { Route, IndexRoute } from 'react-router'
import App from './containers/App'

import PageNotFound from './pages/NotFound'
import PageHome from './pages/Home'
import PageItems from './pages/Items'

export const routes = (
    <div>
        <Route path='/' component={App}>
            <IndexRoute component={PageHome} />
            <Route path='items' component={PageItems} />
            <Route path='*' component={PageNotFound} />
        </Route>
    </div>
);
