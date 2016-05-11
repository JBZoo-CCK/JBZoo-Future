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

import DatePicker    from 'material-ui/DatePicker';

export default class FieldDate extends Component {

    componentWillMount() {

        var value = this.props.value !== undefined ? this.props.value : this.props.data.default;
        var defaultDate = new Date();

        if (value) {
            defaultDate = new Date(value);
        }

        this.setState({value:defaultDate});
    }

    handleChange(event, value) {
        if (this.props.data.onChange) {
            this.props.data.onChange(this.props.name, value);
        }

        this.setState({value});
    }

    render() {

        return <DatePicker
            id={this.props.id}
            name={this.props.name}
            hintText={this.props.data.hint}
            value={this.state.value}
            onChange={::this.handleChange}
        />;
    }
}
