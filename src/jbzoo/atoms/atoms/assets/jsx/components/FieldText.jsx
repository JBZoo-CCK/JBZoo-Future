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

import TextField    from 'material-ui/TextField';

export default class FieldText extends Component {

    componentDidMount() {
        this.setState({
            value: this.props.data.default
        });
    }

    handleChange = (event) => {
        this.setState({
            value: event.target.value
        });
    };

    render() {

        var fieldId = 'field_' + this.props.name;

        return <TextField
            id={fieldId}
            name={this.props.name}
            hintText={this.props.data.hint}
            floatingLabelText={this.props.data.placeholder}
            key={this.props.name}
            fullWidth={this.props.isTextarea ? true : false}
            multiLine={this.props.isTextarea ? true : false}
            rows={this.props.isTextarea ? 2 : 1}
            onChange={this.handleChange}
        />;
    }

}
