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

import * as itemActions        from '../actions/item';

class NewItem extends Component {

    componentDidMount() {
        this.props.itemActions.fetchItemIfNeeded(this.props.params.id);
    }

    render() {

        var item = this.props.items[this.props.params.id];

        if (!item) {
            return (
                <div>Wait please {this.props.params.id}</div>
            );
        }

        return (
            <div>
                <Row>
                    <Col md={12}>
                        sasd
                    </Col>
                </Row>
                <Row>
                    <Col md={9}>
                        {item.name}
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

module.exports = connect(
    (state) => ({
        config: state.config,
        items : state.items
    }),
    (dispatch) => ({
        itemActions: bindActionCreators(itemActions, dispatch)
    })
)(NewItem);
