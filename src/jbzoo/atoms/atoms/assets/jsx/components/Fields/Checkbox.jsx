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

import Checkbox   from 'material-ui/Checkbox';

export default class FieldCheckbox extends Component {

    componentWillMount() {
        var value = this.props.value !== undefined ? this.props.value : this.props.data.default;
        value = value ? true : false;

        this.setState({value});
    }

    handleChange(event, value) {

        this.setState({value});

        if (this.props.data.onChange) {
            this.props.data.onChange(event.target.name, value ? 1 : 0);
        }
    }

    render() {

        return <Checkbox
            id={this.props.id}
            name={this.props.name}
            label={this.props.data.label}
            checked={this.state.value}
            onCheck={::this.handleChange}
            labelPosition="right"
        />;
    }
}
