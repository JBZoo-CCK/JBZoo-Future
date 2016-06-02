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

'use strict';

import React, { Component }     from 'react';
import { connect }              from 'react-redux';
import { bindActionCreators }   from 'redux';
import { Link }  from 'react-router'

const {Grid, Row, Col} = require('react-flexbox-grid');
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';
import {Toolbar, ToolbarGroup} from 'material-ui/Toolbar';
import RaisedButton from 'material-ui/RaisedButton';

class ItemsApp extends Component {

    render() {

        var link = this.context.router.createHref('/items/new');

        return (
            <div>
                <Row>
                    <Col md={12}>
                        <Toolbar>
                            <ToolbarGroup>
                                <RaisedButton label="New" href={link} primary={true} linkButton={true} />
                                <RaisedButton label="Move" secondary={true} />
                                <RaisedButton label="Remove" />
                            </ToolbarGroup>
                        </Toolbar>
                    </Col>
                </Row>

                <Row>
                    <Col md={9}>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHeaderColumn style={{width: '50px'}}>ID</TableHeaderColumn>
                                    <TableHeaderColumn>Name</TableHeaderColumn>
                                    <TableHeaderColumn>Status</TableHeaderColumn>
                                    <TableHeaderColumn>Created</TableHeaderColumn>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableRowColumn style={{width: '50px'}}>1</TableRowColumn>
                                    <TableRowColumn><a href="asd">John Smith</a></TableRowColumn>
                                    <TableRowColumn>Employed</TableRowColumn>
                                    <TableRowColumn>27.05.2017</TableRowColumn>
                                </TableRow>
                                <TableRow>
                                    <TableRowColumn style={{width: '50px'}}>1</TableRowColumn>
                                    <TableRowColumn>Randal White</TableRowColumn>
                                    <TableRowColumn>Unemployed</TableRowColumn>
                                    <TableRowColumn>27.05.2017</TableRowColumn>
                                </TableRow>
                                <TableRow>
                                    <TableRowColumn style={{width: '50px'}}>1</TableRowColumn>
                                    <TableRowColumn>Stephanie Sanders</TableRowColumn>
                                    <TableRowColumn>Employed</TableRowColumn>
                                    <TableRowColumn>27.05.2017</TableRowColumn>
                                </TableRow>
                                <TableRow>
                                    <TableRowColumn style={{width: '50px'}}>1</TableRowColumn>
                                    <TableRowColumn>Steve Brown</TableRowColumn>
                                    <TableRowColumn>Employed</TableRowColumn>
                                    <TableRowColumn>27.05.2017</TableRowColumn>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </Col>
                    <Col md={3}>
                        <h2> Help text</h2>
                        <p>asdasdasd</p>
                    </Col>
                </Row>
            </div>
        );
    }
}

ItemsApp.contextTypes = {
    router: React.PropTypes.object
};

module.exports = ItemsApp;
