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

import React, {PropTypes, Component } from 'react'
const {Grid, Row, Col} = require('react-flexbox-grid');

import FieldText        from '../Fields/Text';
import FieldToggle      from '../Fields/Toggle';
import FieldCheckbox    from '../Fields/Checkbox';
import FieldTime        from '../Fields/Time';
import FieldDate        from '../Fields/Date';
import FieldSelect      from '../Fields/Select';
import FieldRadio       from '../Fields/Radio';
import FieldGroup       from '../Fields/Group';

import * as colors  from 'material-ui/styles/colors';

export default class FormRow extends Component {

    render() {

        var output  = false,
            styles  = {},
            rowData = this.props.rowData,
            rowType = this.props.rowData.type,
            rowName = this.props.rowName,
            rowId   = this.props.rowId;

        if (rowType == 'text') {
            output = <FieldText data={rowData} name={rowName} id={rowId} isTextarea={false} />;
            styles = {paddingTop: "24px"};

        } else if (rowType == 'textarea') {
            output = <FieldText data={rowData} name={rowName} id={rowId} isTextarea={true} />;
            styles = {paddingTop: "24px"};

        } else if (rowType == 'toggle') {
            output = <FieldToggle data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'checkbox') {
            output = <FieldCheckbox data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'select') {
            output = <FieldSelect data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'radio') {
            output = <FieldRadio data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'time') {
            output = <FieldTime data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'date') {
            output = <FieldDate data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'datetime') {
            output = <FieldDatetime data={rowData} name={rowName} id={rowId} />;

        } else if (rowType == 'group') {
            output = <FieldGroup data={rowData} name={rowName} id={rowId} />;
        }

        if (!output) {
            return <span>Undefined field type: {rowType}</span>;
        }

        return (
            <Row style={{marginBottom: "16px"}}>
                <Col md={2} style={styles}>
                    {rowData.label}
                </Col>
                <Col md={5}>
                    {output}
                </Col>
                <Col md={5} style={{color:"#aaa"}}>
                    <div style={styles}>
                        {rowData.description}
                    </div>
                </Col>
            </Row>
        );
    }
}
