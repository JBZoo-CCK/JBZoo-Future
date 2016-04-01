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

var routes = RouteTable.map(r => {
    return (<Route handler={A} name={r.url} path={r.url} />);
});

var routes = (
    <Route path='/'>
        {routes}
    </Route>
);
