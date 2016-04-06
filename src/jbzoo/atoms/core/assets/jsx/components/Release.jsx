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

export default class Release extends Component {
    render() {
        return (
            <div>
                <div className='col-md-12'>Category /genre/release</div>
                {this.props.children}
            </div>
        )
    }
}