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

import React, {PropTypes, Component } from 'react'

import RaisedButton from 'material-ui/RaisedButton';
import {Toolbar, ToolbarGroup, ToolbarSeparator, ToolbarTitle} from 'material-ui/Toolbar';

export default class AtomsToolbar extends Component {

    render() {

        return (
            <Toolbar>
                <ToolbarGroup>
                    <ToolbarTitle text="Atoms general configurations" />
                    <ToolbarSeparator />
                    <RaisedButton label="Save" primary={true} />
                </ToolbarGroup>
            </Toolbar>
        );
    }
}
