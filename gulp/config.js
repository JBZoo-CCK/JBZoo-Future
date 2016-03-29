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

var atomPath = './src/jbzoo/atoms/assets-';

module.exports = {
    path: {
        bower: './bower_components',
        atoms: atomPath
    },

    materialui: {
        browserify: {

            // Enable source maps
            debug: false,

            // A separate bundle will be generated for each bundle config in the list below
            bundleConfigs: [{
                entries   : atomPath + 'material-ui/assets/jsx/app.jsx',
                dest      : atomPath + 'material-ui/assets/js',
                outputName: 'material-ui.js'
            }],

            extensions: ['.jsx']
        }
    }
};
