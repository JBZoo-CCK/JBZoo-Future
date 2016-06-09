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

class NewItem extends Component {

    render() {

        var link = this.context.router.createHref('/items-new');

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
                        Edit
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

NewItem.contextTypes = {
    router: React.PropTypes.object
};

module.exports = NewItem;
