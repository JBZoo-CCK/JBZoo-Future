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

import React from 'react';
import IconMenu from 'material-ui/lib/menus/icon-menu';
import IconButton from 'material-ui/lib/icon-button';
import FontIcon from 'material-ui/lib/font-icon';
import NavigationExpandMoreIcon from 'material-ui/lib/svg-icons/navigation/expand-more';
import MenuItem from 'material-ui/lib/menus/menu-item';
import DropDownMenu from 'material-ui/lib/DropDownMenu';
import RaisedButton from 'material-ui/lib/raised-button';
import Toolbar from 'material-ui/lib/toolbar/toolbar';
import ToolbarGroup from 'material-ui/lib/toolbar/toolbar-group';
import ToolbarSeparator from 'material-ui/lib/toolbar/toolbar-separator';
import ToolbarTitle from 'material-ui/lib/toolbar/toolbar-title';

import TextField from 'material-ui/lib/text-field';
import SvgIcon from 'material-ui/lib/svg-icon';

const HomeIcon = (props) => (
    <SvgIcon {...props}>
        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
    </SvgIcon>
);


const ItemsToolbar = () => (


    <Toolbar>
        <ToolbarGroup >

            <ToolbarTitle text="Item list of catalog" />

            <RaisedButton label="New" primary={true} />
            <RaisedButton label="Edit" primary={true} />
            <RaisedButton label="Move" primary={true} />
            <RaisedButton label="Publish" secondary={true} />
            <RaisedButton label="Unpublish" secondary={true} />

            <TextField hintText={
                    <HomeIcon style={{float:"right"}} />
            } />


        </ToolbarGroup>
    </Toolbar>
);

export default ItemsToolbar;