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
import Formsy                   from 'formsy-react';
import {Toolbar, ToolbarGroup}  from 'material-ui/Toolbar';
import { FormsyText }           from 'formsy-material-ui/lib';
import * as moduleActions       from '../../jsx/actions/module';
import RaisedButton             from 'material-ui/RaisedButton';

const { Row, Col} = require('react-flexbox-grid');

class ModuleAdd extends Component {

    saveModule(data) {
        this.props.moduleActions.addModule(data);
        this.context.router.push('/modules');
    }

    render() {
        var router   = this.context.router,
            listLink = router.createHref('/modules');

        return (
            <div>
                <Formsy.Form onValidSubmit={::this.saveModule}>
                    <Row>
                        <Col md={12}>
                            <Toolbar>
                                <ToolbarGroup>
                                    <RaisedButton
                                        type="submit"
                                        label="Add"
                                        primary={true}
                                    />
                                    <RaisedButton label="Close" href={listLink} linkButton={true} />
                                </ToolbarGroup>
                            </Toolbar>
                        </Col>
                    </Row>
                    <Row>
                        <Col>
                            <div>
                                <FormsyText
                                    name="title"
                                    required
                                    floatingLabelText="Module title"
                                />
                            </div>
                            <div>
                                <FormsyText
                                    name="params"
                                    floatingLabelText="Module params"
                                    multiLine={true}
                                    rows={2}
                                />
                            </div>
                        </Col>
                    </Row>
                </Formsy.Form>
            </div>
        );
    }
}

ModuleAdd.contextTypes = {
    router: React.PropTypes.object
};

module.exports = connect(
    (state) => ({
        modules: state.modules
    }),
    (dispatch) => ({
        moduleActions: bindActionCreators(moduleActions, dispatch)
    })
)(ModuleAdd);
