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

import getMuiTheme  from 'material-ui/styles/getMuiTheme';
import * as colors  from 'material-ui/styles/colors';
import {fade}       from 'material-ui/utils/colorManipulator';

export default getMuiTheme(
    {
        spacing: {},

        fontFamily: 'Roboto, sans-serif',
        palette   : {
            primary1Color     : colors.lightBlue400,
            primary2Color     : colors.lightBlue700,
            primary3Color     : colors.grey300,
            accent1Color      : colors.lightBlue500,
            accent2Color      : colors.grey300,
            accent3Color      : colors.grey500,
            textColor         : colors.darkBlack,
            alternateTextColor: colors.white,
            canvasColor       : colors.white,
            borderColor       : colors.grey500,
            disabledColor     : fade(colors.darkBlack, 0.3),
            pickerHeaderColor : colors.lightBlue500,
            clockCircleColor  : fade(colors.darkBlack, 0.07),
            shadowColor       : colors.fullBlack
        }
    },
    {
        userAgent: navigator.userAgent,
        zIndex   : {
            menu          : 100,
            appBar        : 110,
            leftNavOverlay: 120,
            leftNav       : 130,
            dialogOverlay : 140,
            dialog        : 150,
            layer         : 200,
            popover       : 210,
            snackbar      : 290,
            tooltip       : 300
        }
    }
);
