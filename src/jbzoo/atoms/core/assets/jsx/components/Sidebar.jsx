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

import React, {PropTypes, Component } from 'react'
import { Link } from 'react-router'

import Divider from 'material-ui/lib/divider';
import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';

import { sidebar } from '../store/initialState'

class Sidebar extends Component {
    render() {

        return <List>
            <ListItem containerElement={<Link to="/" />} primaryText="Dashboard" />
            <Divider />
            {
                sidebar.map(function (item, key) {
                    let link = <Link to={item.path} />;
                    return <ListItem key={key} containerElement={link} primaryText={item.name} />;
                })
            }
            <Divider />
            <ListItem containerElement={<Link to="/about" />} primaryText="...about JBZoo" />

        </List>;
    }
}

module.exports = Sidebar;
