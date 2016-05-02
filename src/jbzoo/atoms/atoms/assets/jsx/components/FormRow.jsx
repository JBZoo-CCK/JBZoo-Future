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

import React, {PropTypes, Component } from 'react'
const {Grid, Row, Col} = require('react-flexbox-grid');

import {RadioButton, RadioButtonGroup} from 'material-ui/RadioButton';

import FieldText        from './FieldText';
import FieldToggle      from './FieldToggle';
import FieldCheckbox    from './FieldCheckbox';
import FieldTime        from './FieldTime';
import FieldDate        from './FieldDate';
import FieldSelect      from './FieldSelect';

import * as colors  from 'material-ui/styles/colors';

export default class FormRow extends Component {

    render() {

        var field, styles = {};

        if (this.props.row.type == 'text') {
            field = <FieldText data={this.props.row} name={this.props.rowname} />;
            styles = {paddingTop: "42px"};

        } else if (this.props.row.type == 'textarea') {
            field = <FieldText data={this.props.row} name={this.props.rowname} isTextarea={true} />;
            styles = {paddingTop: "42px"};

        } else if (this.props.row.type == 'toggle') {
            field = <FieldToggle data={this.props.row} name={this.props.rowname} />;

        } else if (this.props.row.type == 'checkbox') {
            field = <FieldCheckbox data={this.props.row} name={this.props.rowname} />;

        } else if (this.props.row.type == 'select') {
            field = <FieldSelect data={this.props.row} name={this.props.rowname} />;

        } else if (this.props.row.type == 'radio') {
            field = <RadioButtonGroup name="shipSpeed" defaultSelected="not_light">
                <RadioButton value="light" label="Simple" />
                <RadioButton value="not_light" label="Selected by default" />
                <RadioButton value="ludicrous" label="Custom icon" />
            </RadioButtonGroup>;

        } else if (this.props.row.type == 'time') {
            field = <FieldTime data={this.props.row} name={this.props.rowname} />;

        } else if (this.props.row.type == 'date') {
            field = <FieldDate data={this.props.row} name={this.props.rowname} />;

        } else if (this.props.row.type == 'datetime') {
            field = <FieldDatetime data={this.props.row} name={this.props.rowname} />;
        }

        if (!field) {
            return <span>Undefined field type: {this.props.row.type}</span>;
        }

        return <Row style={{marginBottom: "16px"}}>
            <Col md={2} style={styles}>{this.props.row.label}</Col>
            <Col md={5}>
                {field}
            </Col>
            <Col md={5} style={{paddingTop:"24px", color:"#aaa"}}>
                {this.props.row.description}
            </Col>
        </Row>;
    }
}
