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

import React from 'react';
const {Grid, Row, Col} = require('react-flexbox-grid');

import List from 'material-ui/lib/lists/list';

import ListItem from 'material-ui/lib/lists/list-item';
import AppBar from 'material-ui/lib/app-bar';
import Paper from 'material-ui/lib/paper';

import Theme from '../components/ActiveTheme';

import LeftNav from 'material-ui/lib/left-nav';
import MenuItem from 'material-ui/lib/menus/menu-item';


import Table from '../components/Table';

const App = React.createClass({

    //the key passed through context must be called "muiTheme"
    childContextTypes: {
        muiTheme: React.PropTypes.object
    },

    getChildContext() {
        return ({muiTheme: Theme});
    },

    render() {
        return (
            <div style={{marginBottom: '24px'}}>
                <Row style={{marginBottom:'24px', marginRight:0 }}>
                    <Col md={12}>
                        <AppBar
                            title={<span>JBZoo CCK Panel <span style={{fontSize:'0.5em'}}>3.x-dev</span></span>}
                            style={{marginTop:'8px'}}
                            titleStyle={{fontSize:'18px'}}
                            showMenuIconButton={true}
                        />
                    </Col>
                </Row>

                <Row style={{marginRight:0 }}>
                    <Col md={2}>
                        <Paper zDepth={1}>
                            <List>
                                <ListItem primaryText="Items" />
                                <ListItem primaryText="Cart" />
                                <ListItem primaryText="Configurations" />
                                <ListItem primaryText="Atoms" />
                                <ListItem primaryText="Something..." />
                            </List>
                        </Paper>
                    </Col>
                    <Col md={10}>
                        <Paper zDepth={1}>
                            <Table />
                        </Paper>
                    </Col>
                </Row>

            </div>
        );
    }
});

export default App;
