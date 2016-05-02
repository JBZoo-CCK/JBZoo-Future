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

import React, { Component } from 'react'

import SelectField  from 'material-ui/SelectField';
import MenuItem     from 'material-ui/MenuItem';

export default class FieldSelect extends Component {

    constructor(props) {
        super(props);
        this.state = {select: 1};
    }

    handleChange = (event, index, select) => this.setState({select});

    render() {

        for (var first in this.props.data.options) break;

        var fieldId = 'field_' + this.props.name;
        var rows = [],
            selected = this.state.select !== undefined ? this.state.select : first;

        _.forEach(this.props.data.options, function (text, key) {
            rows.push(<MenuItem key={key} value={key} primaryText={text} />);
        });

        return <SelectField
            id={fieldId}
            value={selected}
            name={this.props.name}
            onChange={this.handleChange}
        >
            {rows}
        </SelectField>;
    }

}
