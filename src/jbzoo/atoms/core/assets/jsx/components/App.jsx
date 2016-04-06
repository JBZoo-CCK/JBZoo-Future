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

import React, { Component } from 'react'
import { Link } from 'react-router'

export default class App extends Component {
    render() {
        return (
            <div className='container'>
                <h1>App</h1>
                <ul>
                    <li><Link to='/admin'>Admin</Link></li>
                    <li><Link to='/genre'>Genre</Link></li>
                    <li><Link to='/genre/release/release-one'>release-one</Link></li>
                </ul>
                {this.props.children}
            </div>
        )
    }
}