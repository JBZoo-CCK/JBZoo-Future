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
import * as formActions         from '../../jsx/actions/form';
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

    render() {

        var router     = this.context.router,
            moduleId   = this.props.params.id,
            module     = this.props.modules[moduleId],
            listLink   = router.createHref('/modules'),
            removeLink = router.createHref('/modules/remove/' + moduleId);

        let { enableButtons, disableButtons, updateModule } = this.props.formActions;

        return (
            <div>
                {module ?
                    <Formsy.Form
                        onValidSubmit={updateModule}
                        onValid={enableButtons}
                        onInvalid={disableButtons}
                    >
                        <Row>
                            <Col md={12}>
                                <Toolbar>
                                    <ToolbarGroup>
                                        <RaisedButton
                                            type="submit"
                                            label="Update"
                                            primary={true}
                                            disabled={!this.props.handleFormButton.canSubmit}
                                        />
                                        <RaisedButton label="Close" href={listLink} linkButton={true} />
                                        <RaisedButton label="Remove" href={removeLink} linkButton={true} />
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
        modules: state.modules,
        handleFormButton: state.handleFormButton,
        handleFormSend: state.handleFormSend
    }),
    (dispatch) => ({
        modulesActions: bindActionCreators(modulesActions, dispatch),
        formActions: bindActionCreators(formActions, dispatch)
    })
)(ModuleEdit);
