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
import Admin from './components/Admin'
import Genre from './components/Genre'
import Release from './components/Release'
import ReleaseItem from './components/ReleaseItem'
import Home from './components/Home'
import NotFound from './components/NotFound'

export const routes = (
    <div>
        <Route path='/' component={App}>
            <IndexRoute component={Home} />
            <Route path='admin' component={Admin} />
            <Route path='genre' component={Genre}>
                <Route path='release' component={Release}>
                    <Route path=':name' component={ReleaseItem} />
                </Route>
            </Route>
        </Route>
        <Route path='*' component={NotFound} />
    </div>
);
