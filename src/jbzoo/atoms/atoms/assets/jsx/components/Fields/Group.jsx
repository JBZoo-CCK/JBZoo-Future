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
import {RadioButton, RadioButtonGroup} from 'material-ui/RadioButton';
import * as colors  from 'material-ui/styles/colors';

import FieldText        from './Text';
import FieldToggle      from './Toggle';
import FieldCheckbox    from './Checkbox';
import FieldTime        from './Time';
import FieldDate        from './Date';
import FieldSelect      from './Select';
import FieldRadio       from './Radio';


export default class FieldGroup extends Component {

    render() {

        var field,
            groupId    = this.props.id,
            groupName  = this.props.name,
            groupValue = this.props.value,
            onChange   = this.props.data.onChange,
            rows       = [];

        _.forEach(this.props.data.childs, function (fieldData, key) {

            field = false;
            var fieldId   = groupId + '_' + key,
                fieldName = groupName + '.' + key,
                rowValue  = groupValue[key];

            fieldData.onChange = onChange;

            if (fieldData.type == 'text') {
                field = <FieldText key={key} data={fieldData} name={fieldName} onChange={onChange}
                                   id={fieldId} value={rowValue} isTextarea={false} />;

            } else if (fieldData.type == 'textarea') {
                field = <FieldText key={key} data={fieldData} name={fieldName} onChange={onChange}
                                   id={fieldId} value={rowValue} isTextarea={true} />;

            } else if (fieldData.type == 'toggle') {
                field = <FieldToggle key={key} data={fieldData} name={fieldName}
                                     id={fieldId} value={rowValue} onChange={onChange} />;

            } else if (fieldData.type == 'checkbox') {
                field = <FieldCheckbox key={key} data={fieldData} name={fieldName}
                                       id={fieldId} value={rowValue} onChange={onChange} />;

            } else if (fieldData.type == 'select') {
                field = <FieldSelect key={key} data={fieldData} name={fieldName}
                                     id={fieldId} value={rowValue} onChange={onChange} />;

            } else if (fieldData.type == 'radio') {
                field = <FieldRadio key={key} data={fieldData} name={fieldName}
                                    id={fieldId} value={rowValue} onChange={onChange} />;

            } else if (fieldData.type == 'time') {
                field = <FieldTime key={key} data={fieldData} name={fieldName}
                                   id={fieldId} value={rowValue} onChange={onChange} />;

            } else if (fieldData.type == 'date') {
                field = <FieldDate key={key} data={fieldData} name={fieldName}
                                   id={fieldId} value={rowValue} onChange={onChange} />;
            }

            if (!field) {
                field = <span key={fieldId}>Undefined field type: {fieldData.type}</span>;
            }

            rows.push(field);
        });

        return <div>{rows}</div>;
    }
}
