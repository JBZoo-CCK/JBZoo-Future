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
import Admin from './components/Admin'
import Genre from './components/Genre'
import Home from './components/Home'


export default class JBZooApp extends Component {

    constructor(props) {
        super(props);
        this.state = {
            route: window.location.hash.substr(1)
        }
    }

    componentDidMount() {
        window.addEventListener('hashchange', () => {
            this.setState({
                route: window.location.hash.substr(1)
            })
        })
    }

    render() {
        let Child;

        switch (this.state.route) {
            case '/admin':
                Child = Admin;
                break;
            case '/genre':
                Child = Genre;
                break;
            default:
                Child = Home;
        }

        return (
            <div className='container'>
                <h1>App</h1>
                <ul>
                    <li><a href='#/admin'>Admin</a></li>
                    <li><a href='#/genre'>Genre</a></li>
                </ul>
                <Child />
            </div>
        )

    }
}