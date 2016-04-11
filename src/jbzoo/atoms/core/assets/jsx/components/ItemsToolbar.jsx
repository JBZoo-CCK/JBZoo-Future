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
import IconAdd from 'material-ui/lib/svg-icons/content/add';
import IconEdit from 'material-ui/lib/svg-icons/image/edit';
import IconMove from 'material-ui/lib/svg-icons/action/compare-arrows';
import IconPublish from 'material-ui/lib/svg-icons/navigation/check';

var stylesss = {
    height: 16,
    width : 16
};

const ItemsToolbar = () => (
    <Toolbar>
        <ToolbarGroup >
            <ToolbarTitle text="Item list of catalog" />
            <RaisedButton label="New" labelPosition="before"  primary={true} icon={<IconAdd  style={stylesss} />} />
            <RaisedButton label="Edit" labelPosition="before"  secondary={true} icon={<IconEdit  style={stylesss} />} />
            <RaisedButton label="Move" labelPosition="before" icon={<IconMove  style={stylesss} />} />
            <RaisedButton label="Publish" labelPosition="before" icon={<IconPublish  style={stylesss} />} />
        </ToolbarGroup>
    </Toolbar>
);

export default ItemsToolbar;