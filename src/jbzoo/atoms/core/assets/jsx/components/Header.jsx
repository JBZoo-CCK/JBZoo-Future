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
import { connect }      from 'react-redux'
import Toolbar          from 'material-ui/Toolbar/Toolbar';
import ToolbarGroup     from 'material-ui/Toolbar/ToolbarGroup';
import ToolbarTitle     from 'material-ui/Toolbar/ToolbarTitle';
import TextField        from 'material-ui/TextField';
import RefreshIndicator from 'material-ui/RefreshIndicator';

class Sidebar extends Component {

    render() {

        let progressMode = 'hide';
        if (this.props.isLoading) {
            progressMode = 'loading';
        }

        return <div>
            <Toolbar style={{backgroundColor:"#10223e"}}>
                <ToolbarGroup>
                    <span className="jbzoo-logo" />
                    <ToolbarTitle
                        text="JBZoo CCK Panel — 3.x-dev"
                        style={{
                            color      :"#fff",
                            lineHeight :"40px",
                            marginTop  :"8px",
                            marginLeft : "52px"
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
                    <RefreshIndicator
                        size={50}
                        left={10}
                        top={4}
                        status={progressMode}
                        style={{backgroundColor:"none", position:"relative"}}
                    />
                </ToolbarGroup>
            </Toolbar>
        </div>;
    }
}

export default Sidebar;
