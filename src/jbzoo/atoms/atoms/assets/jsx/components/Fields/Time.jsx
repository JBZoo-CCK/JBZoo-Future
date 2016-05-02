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

import TimePicker    from 'material-ui/TimePicker';

export default class FieldTime extends Component {

    render() {

        var defaultTime = new Date();

        dump(this.props.data.default);

        if (this.props.data.default) {
            let parts = this.props.data.default.split(':');
            defaultTime = new Date(0, 0, 0, parts[0], parts[1]);
        }

        return <TimePicker
            id={this.props.id}
            name={this.props.name}
            value={defaultTime}
            hintText={this.props.data.hint}
            format="24hr"
        />;
    }

}
