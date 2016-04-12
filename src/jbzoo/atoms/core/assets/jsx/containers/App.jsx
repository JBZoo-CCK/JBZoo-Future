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
import LeftNav from 'material-ui/lib/left-nav';
import MenuItem from 'material-ui/lib/menus/menu-item';
import LinearProgress from 'material-ui/lib/linear-progress';
import Toolbar from 'material-ui/lib/toolbar/toolbar';
import ToolbarTitle from 'material-ui/lib/toolbar/toolbar-title';
import ToolbarGroup from 'material-ui/lib/toolbar/toolbar-group';
import SvgIcon from 'material-ui/lib/svg-icons/image/adjust';
import Divider from 'material-ui/lib/divider';
import TextField from 'material-ui/lib/text-field';

import SearchIcon from 'material-ui/lib/svg-icons/action/search';
import IconList from 'material-ui/lib/svg-icons/action/list';
import IconCategory from 'material-ui/lib/svg-icons/file/folder';
import IconApps from 'material-ui/lib/svg-icons/navigation/apps';
import IconTags from 'material-ui/lib/svg-icons/action/label';
import IconSettings from 'material-ui/lib/svg-icons/action/settings';
import IconComments from 'material-ui/lib/svg-icons/communication/comment';
import IconCart from 'material-ui/lib/svg-icons/action/shopping-cart';
import IconOrders from 'material-ui/lib/svg-icons/action/reorder';


import Theme from '../components/ActiveTheme';
import Table from '../components/Table';
import ItemsToolbar from '../components/ItemsToolbar';
import FloatingActionButtonList from '../components/FAB.jsx';


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
                                <ListItem
                                    key="list_1"
                                    leftIcon={<IconList />}
                                    primaryText="Content"
                                    primaryTogglesNestedList={true}
                                    nestedItems={[
                                        <ListItem primaryText="Catalogs" leftIcon={<IconApps />} key="list_2" />,
                                        <ListItem primaryText="Categories" leftIcon={<IconCategory />} key="list_3" />,
                                        <ListItem primaryText="Items" leftIcon={<IconList />} key="list_4" />,
                                        <ListItem primaryText="Tags" leftIcon={<IconTags />} key="list_5" />,
                                        <ListItem primaryText="Types" leftIcon={<IconSettings />} key="list_6" />
                                    ]}
                                />
                                <ListItem primaryText="Comments" leftIcon={<IconComments />} key="list_7" />
                                <ListItem primaryText="Orders" leftIcon={<IconOrders />} key="list_8" />
                                <ListItem
                                    key="list_9"
                                    leftIcon={<IconCart />}
                                    primaryText="Cart"
                                    primaryTogglesNestedList={true}
                                    nestedItems={[
                                        <ListItem primaryText="Payments" key="list_10" />,
                                        <ListItem primaryText="Categories" key="list_11" />,
                                        <ListItem primaryText="Items" key="list_12" />,
                                        <ListItem primaryText="Tags" key="list_13" />,
                                        <ListItem primaryText="Types" key="list_14" />
                                    ]}
                                />
                                <Divider />
                                <ListItem primaryText="Atoms" key="list_15" />
                                <ListItem primaryText="Modules" key="list_16" />
                                <ListItem primaryText="Configurations" key="list_17" />
                                <ListItem primaryText="Something..." key="list_18" />
                            </List>
                        </Paper>
                    </Col>
                    <Col md={10}>
                        <Paper zDepth={1}>
                            <ItemsToolbar />
                            <Table />
                            <FloatingActionButtonList />
                        </Paper>
                    </Col>
                </Row>

            </div>
        );
    }
});

export default App;
