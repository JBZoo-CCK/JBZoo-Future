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

import React, { Component } from 'react'

import {RadioButton, RadioButtonGroup} from 'material-ui/RadioButton';

export default class FieldRadio extends Component {

    componentWillMount() {

        for (var first in this.props.data.options) break;
        var selected = this.props.value !== undefined ? this.props.value : this.props.data.default;
        selected = selected !== undefined ? selected : first;

        this.state = {value: "" + selected};
    }

    handleChange(event, value) {
        if (this.props.data.onChange) {
            this.props.data.onChange(this.props.name, value);
        }

        this.setState({value});
    }

    render() {

        var value = this.state.value;

        var rows = [];
        _.forEach(this.props.data.options, function (text, key) {
            rows.push(<RadioButton key={key} value={key} label={text} />);
        });

        if (!this.props.data.options[value]) {
            let label = `Undefined option: ${value}`;
            rows.push(<RadioButton key={value} value={value} label={label} />);
        }

        return <RadioButtonGroup
            id={this.props.id}
            name={this.props.name}
            valueSelected={value}
            onChange={::this.handleChange}
        >
            {rows}
        </RadioButtonGroup>;
    }

}
