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

import React, {Component, PropTypes} from 'react';
import Formsy                   from 'formsy-react';
import {connect}              from 'react-redux';
import {bindActionCreators}   from 'redux';
import RaisedButton             from 'material-ui/RaisedButton';

const {Row, Col} = require('react-flexbox-grid');
import {Toolbar, ToolbarGroup}  from 'material-ui/Toolbar';

import {
    FormsyCheckbox, FormsyDate, FormsyRadio, FormsyRadioGroup,
    FormsySelect, FormsyText, FormsyTime, FormsyToggle
}
    from 'formsy-material-ui/lib';

import * as itemActions             from '../actions/item';

class EditItem extends Component {

    saveItem(data) {
        this.props.itemActions.saveItem(data);
        this.context.router.push('/items');
    }

    removeItem() {
        this.props.itemActions.removeItem(this.props.params.id);
        this.context.router.push('/items');
    }

    componentDidMount() {
        let id = this.props.params.id;
        if (id == 'new') {
            this.props.itemActions.fetchNewItem();
        } else {
            this.props.itemActions.fetchItemIfNeeded(id);
        }
    }

    render() {

        let item = this.props.items[this.props.params.id];
        if (!item) {
            return (<div>Load item info. Please wait.</div>);
        }

        var rows = [];
        _.forEach(item, function (itemValue, key) {

            if (_.isArray(itemValue)) {
                itemValue = itemValue.join('');
            }

            if (['name', 'alias'].indexOf(key) >= 0) {
                rows.push(<div key={key}>
                    <FormsyText
                        name={key}
                        floatingLabelText={key}
                        value={itemValue}
                    />
                </div>);
            }
        });

        return (

            <div>
                <Formsy.Form onValidSubmit={::this.saveItem}>
                    <Row>
                        <Col md={12}>
                            <Toolbar>
                                <ToolbarGroup>
                                    <RaisedButton
                                        type="submit"
                                        label="Save item"
                                        primary={true}
                                    />
                                    {
                                        this.props.params.id != 'new' ?
                                            <RaisedButton
                                                label="Remove item"
                                                primary={false}
                                                onMouseUp={::this.removeItem}
                                            />
                                            : false
                                    }
                                </ToolbarGroup>
                            </Toolbar>
                        </Col>
                    </Row>

                    <Row>
                        <Col md={9}>

                            <Row>
                                <Col md={9}>
                                    {rows}
                                </Col>
                                <Col md={3}>

                                    <table>
                                        <tbody>
                                        <tr key="item_id">
                                            <td><strong>Item ID:</strong></td>
                                            <td>{item.id}</td>
                                        </tr>
                                        <tr key="item_type">
                                            <td><strong>Type:</strong></td>
                                            <td>{item.type}</td>
                                        </tr>
                                        <tr key="item_status">
                                            <td><strong>Status:</strong></td>
                                            <td>{item.status}</td>
                                        </tr>
                                        <tr key="item_created">
                                            <td><strong>Created:</strong></td>
                                            <td>{item.created}</td>
                                        </tr>
                                        <tr key="item_author">
                                            <td><strong>Author:</strong></td>
                                            <td>{item.created_by}</td>
                                        </tr>
                                        <tr key="item_modified">
                                            <td><strong>Modified:</strong></td>
                                            <td>{item.modified}</td>
                                        </tr>
                                        <tr key="item_publish_up">
                                            <td><strong>Publish up:</strong></td>
                                            <td>{item.publish_up}</td>
                                        </tr>
                                        <tr key="item_publish_down">
                                            <td><strong>Publish down:</strong></td>
                                            <td>{item.publish_down}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div>
                                        <strong>Params:</strong> {item.params}
                                    </div>

                                </Col>
                            </Row>

                        </Col>
                        <Col md={3}>
                            <h2> Help text</h2>
                            <p>asdasdasd</p>
                        </Col>
                    </Row>
                </Formsy.Form>
            </div>
        );
    }
}

EditItem.contextTypes = {
    router: PropTypes.object.isRequired
};

module.exports = connect(
    (state) => ({
        config: state.config,
        items : state.items
    }),
    (dispatch) => ({
        itemActions: bindActionCreators(itemActions, dispatch)
    })
)(EditItem);
