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

import List from 'material-ui/lib/lists/list';
import ListItem from 'material-ui/lib/lists/list-item';
import AppBar from 'material-ui/lib/app-bar';
import Paper from 'material-ui/lib/paper';
import LeftNav from 'material-ui/lib/left-nav';
import MenuItem from 'material-ui/lib/menus/menu-item';
import LinearProgress from 'material-ui/lib/linear-progress';
import Toolbar from 'material-ui/lib/toolbar/toolbar';
import ToolbarTitle from 'material-ui/lib/toolbar/toolbar-title';
import ToolbarGroup from 'material-ui/lib/toolbar/toolbar-group';
import SvgIcon from 'material-ui/lib/svg-icons/image/adjust';
import Divider from 'material-ui/lib/divider';
import TextField from 'material-ui/lib/text-field';

import Theme from '../components/ActiveTheme';
import Year from '../components/Year';

import { bindActionCreators } from 'redux'
import * as pageActions from '../actions/PageActions'


class App extends Component {

    getChildContext() {
        return ({muiTheme: Theme});
    }

    render() {

        const { user, page } = this.props;
        const { getPhotos } = this.props.pageActions;

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
                        <div>
                            <Year photos={page.photos} year={page.year} getPhotos={getPhotos} fetching={page.fetching} />
                        </div>

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

function mapStateToProps(state) {
    return {
        user: state.user,
        page: state.page
    }
}

function mapDispatchToProps(dispatch) {
    return {
        pageActions: bindActionCreators(pageActions, dispatch)
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(App)
