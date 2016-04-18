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

import React, {Component} from 'react';
import { Link } from 'react-router'
import { connect } from 'react-redux'

const {Grid, Row, Col} = require('react-flexbox-grid');

import Toolbar from 'material-ui/lib/toolbar/toolbar';
import ToolbarGroup from 'material-ui/lib/toolbar/toolbar-group';
import ToolbarTitle from 'material-ui/lib/toolbar/toolbar-title';
import TextField from 'material-ui/lib/text-field';
import LinearProgress from 'material-ui/lib/linear-progress';
import Paper from 'material-ui/lib/paper';
import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';


import Theme from '../components/ActiveTheme';


class App extends Component {

    getChildContext() {
        return ({muiTheme: Theme});
    }

    render() {

        return (
            <div style={{marginBottom: "24px", marginTop:"8px"}}>

                <Row style={{marginBottom:"24px", marginRight:0 }}>
                    <Col md={12}>
                        <Toolbar style={{backgroundColor:"#10223e"}}>

                            <ToolbarGroup>
                                <span className="jbzoo-logo" />
                                <ToolbarTitle
                                    text="JBZoo CCK Panel — 3.x-dev"
                                    style={{
                                        color:"#fff",
                                        lineHeight:"40px",
                                        marginTop:"8px",
                                        marginLeft:"52px"
                                    }}
                                />
                            </ToolbarGroup>

                            <ToolbarGroup firstChild={true} float="right" style={{lineHeight:"40px"}}>
                                <TextField hintText="Global search"
                                           hintStyle={{color:"#aaa"}}
                                           inputStyle={{
                                                color:"#fff",
                                                backgroundCcolor: "#eee"
                                            }}
                                />

                            </ToolbarGroup>
                        </Toolbar>

                        <LinearProgress mode="determinate" value={40} />
                    </Col>
                </Row>

                <Row style={{marginRight:0 }}>
                    <Col md={2}>
                        <Paper zDepth={1}>
                            <List>
                                <ListItem containerElement={<Link to="/" />} primaryText="Main" />
                                <ListItem containerElement={<Link to="/items" />} primaryText="Items" />
                            </List>
                        </Paper>
                    </Col>
                    <Col md={10}>
                        {this.props.children}
                    </Col>
                </Row>

            </div>
        );
    }
}

//the key passed through context must be called "muiTheme"
App.childContextTypes = {
    muiTheme: React.PropTypes.object
};

export default App;
