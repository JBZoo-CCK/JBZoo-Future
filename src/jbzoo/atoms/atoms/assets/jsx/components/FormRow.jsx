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
import Toggle       from 'material-ui/Toggle';
import TextField    from 'material-ui/TextField';
import MenuItem     from 'material-ui/MenuItem';
import Checkbox     from 'material-ui/Checkbox';
import SelectField  from 'material-ui/SelectField';
import TimePicker   from 'material-ui/TimePicker';
import DatePicker   from 'material-ui/DatePicker';

import * as colors  from 'material-ui/styles/colors';

var rowStyles = {marginBottom: "16px"};

export default class FormRow extends Component {

    render() {

        var field, styles = {};

        if (this.props.row.type == 'text') {
            field = <TextField />;
            styles = {paddingTop: "42px"};

        } else if (this.props.row.type == 'textarea') {
            field = <TextField />;

        } else if (this.props.row.type == 'toggle') {
            field = <Toggle />;

        } else if (this.props.row.type == 'checkbox') {
            field = <Checkbox />;

        } else if (this.props.row.type == 'select') {
            field = <SelectField value={1}>
                <MenuItem value={1} primaryText="Never" />
                <MenuItem value={2} primaryText="Every Night" />
                <MenuItem value={3} primaryText="Weeknights" />
                <MenuItem value={4} primaryText="Weekends" />
                <MenuItem value={5} primaryText="Weekly" />
            </SelectField>;

        } else if (this.props.row.type == 'radio') {
            field = <RadioButtonGroup name="shipSpeed" defaultSelected="not_light">
                <RadioButton value="light" label="Simple" />
                <RadioButton value="not_light" label="Selected by default" />
                <RadioButton value="ludicrous" label="Custom icon" />
            </RadioButtonGroup>;

        } else if (this.props.row.type == 'time') {
            field = <TimePicker format="24hr" hintText="24hr Format" />;

        } else if (this.props.row.type == 'date') {
            field = <DatePicker hintText="Portrait Dialog" />;
        }

        if (!field) {
            return <span />;
        }

        return <Row style={rowStyles}>
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