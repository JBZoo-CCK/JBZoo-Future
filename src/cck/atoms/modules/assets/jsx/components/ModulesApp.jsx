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
import { bindActionCreators }   from 'redux';
import { connect }              from 'react-redux';
import {Toolbar, ToolbarGroup}  from 'material-ui/Toolbar';
import * as modulesActions      from '../../jsx/actions/modules';
import RaisedButton             from 'material-ui/RaisedButton';

const {Row, Col} = require('react-flexbox-grid');
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';

class ModulesApp extends Component {

    componentDidMount() {
        this.props.modulesActions.fetchModulesIfNeeded();
    }

    render() {

        var router  = this.context.router,
            addLink = router.createHref('/modules/add'),
            modules = this.props.modules;

        var rows = [];
        _.forEach(modules, function (module, key) {

            let editLink = router.createHref('/modules/edit/' + module.id);

            rows.push(<TableRow key={key}>
                <TableRowColumn style={{width: '50px'}}>{module.id}</TableRowColumn>
                <TableRowColumn><a href={editLink}>{module.title}</a></TableRowColumn>
            </TableRow>);
        });

        return (
            <div>
                <Row>
                    <Col md={12}>
                        <Toolbar>
                            <ToolbarGroup>
                                <RaisedButton label="New" href={addLink} primary={true} linkButton={true} />
                            </ToolbarGroup>
                        </Toolbar>
                    </Col>
                </Row>

                <Row>
                    <Col md={9}>

                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHeaderColumn tooltip="ID" style={{width: '50px'}}>ID</TableHeaderColumn>
                                    <TableHeaderColumn tooltip="Module name">Name</TableHeaderColumn>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                {rows}
                            </TableBody>
                        </Table>

                    </Col>
                    <Col md={3}>
                        <h2>Help text</h2>
                        <p>custom text</p>
                    </Col>
                </Row>
            </div>
        );
    }
}


ModulesApp.contextTypes = {
    router: React.PropTypes.object
};

module.exports = connect(
    (state) => ({
        modules: state.modules
    }),
    (dispatch) => ({
        modulesActions: bindActionCreators(modulesActions, dispatch)
    })
)(ModulesApp);
