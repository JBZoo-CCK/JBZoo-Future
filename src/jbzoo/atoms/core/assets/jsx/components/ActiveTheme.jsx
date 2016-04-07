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

import getMuiTheme from 'material-ui/lib/styles/getMuiTheme';

export default getMuiTheme(
    {
        spacing: {},

        fontFamily: 'Roboto, sans-serif',
        palette   : {
            primary1Color: '#10223e'
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
        },
        appBar   : {
            height: 48
        }
    }
);
