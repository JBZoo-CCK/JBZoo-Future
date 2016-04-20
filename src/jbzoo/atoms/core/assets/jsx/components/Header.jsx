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

import React, {PropTypes, Component } from 'react'

import Toolbar          from 'material-ui/Toolbar/Toolbar';
import ToolbarGroup     from 'material-ui/Toolbar/ToolbarGroup';
import ToolbarTitle     from 'material-ui/Toolbar/ToolbarTitle';
import TextField        from 'material-ui/TextField';
import LinearProgress   from 'material-ui/LinearProgress';

class Sidebar extends Component {

    render() {
        return <div>
            <Toolbar style={{backgroundColor:"#10223e"}}>
                <ToolbarGroup>
                    <span className="jbzoo-logo" />
                    <ToolbarTitle
                        text="JBZoo CCK Panel — 3.x-dev"
                        style={{
                        color:"#fff",
                        lineHeight:"40px",
                        marginTop:"8px",
                        marginLeft:"52px"
                    }}
                    />
                </ToolbarGroup>
                <ToolbarGroup firstChild={true} float="right" style={{lineHeight:"40px"}}>
                    <TextField hintText="Global search"
                               hintStyle={{color:"#aaa"}}
                               inputStyle={{
                                color:"#fff",
                                backgroundCcolor: "#eee"
                            }}
                    />
                </ToolbarGroup>
            </Toolbar>

            <LinearProgress mode="determinate" value={40} />
        </div>;
    }
}

module.exports = Sidebar;
