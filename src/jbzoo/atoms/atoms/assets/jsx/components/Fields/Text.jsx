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

        return <TextField
            id={this.props.id}
            name={this.props.name}
            hintText={this.props.data.hint}
            floatingLabelText={this.props.data.placeholder}
            defaultValue={this.props.data.default}
            key={this.props.name}
            multiLine={this.props.isTextarea ? true : false}
            rows={this.props.isTextarea ? 2 : 1}
            onChange={this.handleChange}
        />;
    }

}
