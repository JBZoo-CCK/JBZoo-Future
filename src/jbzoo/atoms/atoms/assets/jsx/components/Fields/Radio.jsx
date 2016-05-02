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

import {RadioButton, RadioButtonGroup} from 'material-ui/RadioButton';

export default class FieldRadio extends Component {

    render() {

        var rows = [];
        _.forEach(this.props.data.options, function (text, key) {
            rows.push(<RadioButton key={key} value={key} label={text} />);
        });

        return <RadioButtonGroup
            id={this.props.id}
            name={this.props.name}
            defaultSelected={""+this.props.data.default}
        >
            {rows}
        </RadioButtonGroup>;
    }

}
