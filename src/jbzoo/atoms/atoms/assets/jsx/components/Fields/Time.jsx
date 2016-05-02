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

        return <TimePicker
            id={this.props.id}
            name={this.props.name}
            /* defaultTime={this.props.data.default} */
            hintText={this.props.data.hint}
            format="24hr"
        />;
    }

}
