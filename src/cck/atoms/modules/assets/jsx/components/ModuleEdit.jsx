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
import * as moduleActions       from '../../jsx/actions/module';
import * as modulesActions      from '../../jsx/actions/modules';
import { FormsyText }           from 'formsy-material-ui/lib';
import RaisedButton             from 'material-ui/RaisedButton';

const { Row, Col} = require('react-flexbox-grid');

class ModuleEdit extends Component {

    componentDidMount() {
        let modules = this.props.modules;
        if (Object.keys(modules).length === 0) {
            this.props.modulesActions.fetchModulesIfNeeded();
        }
    }

    removeModule() {
        this.props.moduleActions.removeModule(this.props.params.id);
        this.context.router.push('/modules');
    }

    updateModule(data) {
        this.props.moduleActions.updateModule(data);
        this.context.router.push('/modules');
    }

    render() {

        var router     = this.context.router,
            moduleId   = this.props.params.id,
            module     = this.props.modules[moduleId],
            listLink   = router.createHref('/modules');

        return (
            <div>
                {module ?
                    <Formsy.Form onValidSubmit={::this.updateModule}>
                        <Row>
                            <Col md={12}>
                                <Toolbar>
                                    <ToolbarGroup>
                                        <RaisedButton
                                            type="submit"
                                            label="Update"
                                            primary={true}
                                        />
                                        <RaisedButton label="Close" href={listLink} linkButton={true} />
                                        <RaisedButton
                                            label="Remove"
                                            linkButton={true}
                                            onMouseUp={::this.removeModule}
                                        />
                                    </ToolbarGroup>
                                </Toolbar>
                            </Col>
                        </Row>
                        <Row>
                            <Col>
                                <FormsyText
                                    value={module.id}
                                    name="id"
                                    required
                                    type="hidden"
                                    style={{position: "absolute", left: "-9999px"}}
                                    floatingLabelText="Id"
                                />
                                <div>
                                    <FormsyText
                                        value={module.title}
                                        name="title"
                                        required
                                        floatingLabelText="Module title"
                                    />
                                </div>
                                <div>
                                    <FormsyText
                                        name="params"
                                        value={module.params}
                                        floatingLabelText="Module params"
                                        multiLine={true}
                                        rows={2}
                                    />
                                </div>
                            </Col>
                        </Row>
                    </Formsy.Form>
                    :
                    <p>No module</p>
                }
            </div>
        );
    }
}

ModuleEdit.contextTypes = {
    router: React.PropTypes.object
};

module.exports = connect(
    (state) => ({
        modules: state.modules
    }),
    (dispatch) => ({
        modulesActions: bindActionCreators(modulesActions, dispatch),
        moduleActions: bindActionCreators(moduleActions, dispatch)
    })
)(ModuleEdit);
