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

import TimePicker    from 'material-ui/TimePicker';

export default class FieldTime extends Component {

    componentWillMount() {

        var value = this.props.value !== undefined ? this.props.value : this.props.data.default;
        var defaultTime = new Date(value);

        if (value) {

            if (typeof value === 'string') {
                let parts = value.split(':');
                if (parts.length === 2) {
                    defaultTime = new Date(0, 0, 0, parts[0], parts[1]);
                }

            } else {
                defaultTime = new Date(value);
            }
        }

        this.setState({value: defaultTime});
    }

    handleChange(event, value) {
        if (this.props.data.onChange) {
            this.props.data.onChange(this.props.name, value);
        }

        this.setState({value});
    }

    render() {
        return <TimePicker
            id={this.props.id}
            name={this.props.name}
            hintText={this.props.data.hint}
            format="24hr"
            value={this.state.value}
            onChange={::this.handleChange}
        />;
    }
}
