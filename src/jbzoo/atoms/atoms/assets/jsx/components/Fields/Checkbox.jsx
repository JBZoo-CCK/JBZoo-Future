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

import Checkbox   from 'material-ui/Checkbox';

export default class FieldCheckbox extends Component {

    render() {

        var fieldId = 'field_' + this.props.name;

        return <Checkbox
            id={this.props.id}
            name={this.props.name}
            label={this.props.data.label}
            labelPosition="right"
            defaultChecked={this.props.data.default}
        />;
    }
}
