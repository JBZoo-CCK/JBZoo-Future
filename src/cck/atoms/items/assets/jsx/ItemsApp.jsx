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
import { Link }                 from 'react-router'

const {Grid, Row, Col} = require('react-flexbox-grid');
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';
import {Toolbar, ToolbarGroup}  from 'material-ui/Toolbar';
import RaisedButton             from 'material-ui/RaisedButton';

import * as itemsActions        from './actions/items';

class ItemsApp extends Component {

    componentDidMount() {
        this.props.itemsActions.fetchItemsIfNeeded();
    }

    render() {

        var router = this.context.router,
            link   = router.createHref('/items/new');

        if (!this.props.items) {
            return <div>Loading item list...</div>
        }

        var rows = [];
        _.forEach(this.props.items, function (itemRow, key) {

            let itemLink = router.createHref('/items/edit/' + itemRow.id);

            rows.push(<TableRow key={key}>
                <TableRowColumn style={{width: '50px'}}>{itemRow.id}</TableRowColumn>
                <TableRowColumn><a href={itemLink}>{itemRow.name}</a></TableRowColumn>
                <TableRowColumn>{itemRow.status}</TableRowColumn>
            </TableRow>);
        });

        return (
            <div>
                <Row>
                    <Col md={12}>
                        <Toolbar>
                            <ToolbarGroup>
                                <RaisedButton label="New" href={link} primary={true} linkButton={true} />
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
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {rows}
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

module.exports = connect(
    (state) => ({
        config: state.config,
        items : state.items
    }),
    (dispatch) => ({
        itemsActions: bindActionCreators(itemsActions, dispatch)
    })
)(ItemsApp);
