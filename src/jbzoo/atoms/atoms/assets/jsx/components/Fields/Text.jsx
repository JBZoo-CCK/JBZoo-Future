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

import TextField    from 'material-ui/TextField';

export default class FieldText extends Component {

    componentWillMount() {
        var value = this.props.value !== undefined ? this.props.value : this.props.data.default;
        this.setState({value: "" + value});
    }

    handleChange(event) {
        this.setState({value: event.target.value});
    };

    handleBlur() {
        if (this.props.data.onChange) {
            this.props.data.onChange(this.props.name, this.state.value);
        }
    };

    render() {

        return <TextField
            id={this.props.id}
            name={this.props.name}
            hintText={this.props.data.hint}
            floatingLabelText={this.props.data.placeholder}
            value={this.state.value}
            multiLine={this.props.isTextarea ? true : false}
            rows={this.props.isTextarea ? 2 : 1}
            onChange={::this.handleChange}
            onBlur={::this.handleBlur}
        />;
    }
}
