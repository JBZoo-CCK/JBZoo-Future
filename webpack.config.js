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

var webpack = require('webpack');
var path    = require('path');
var isDev   = process.env.NODE_ENV === 'development';

var pluginList = [
    new webpack.BannerPlugin("This file is part of the JBZoo CCK package."),
    new webpack.optimize.CommonsChunkPlugin({
        name     : "assets-common",
        minChunks: 2
    })
];

if (isDev) {
    pluginList.push(
        //new webpack.HotModuleReplacementPlugin()
    )

} else {
    pluginList.push(
        new webpack.optimize.UglifyJsPlugin({compress: {warnings: false}}),
        new webpack.optimize.DedupePlugin(),
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify('production')
            }
        }),
        new webpack.NoErrorsPlugin()
    );
}

module.exports = {

    context: path.resolve(__dirname, 'src/jbzoo/atoms'),

    entry: {
        // "AtomName"       : "./**/index/path.jsx"
        "assets-material-ui": './assets-material-ui/assets/jsx/material-ui.jsx',
        "core"              : './core/assets/jsx/index.jsx'
    },

    output: {
        path    : path.resolve(__dirname, 'src/jbzoo/atoms'),
        filename: "[name]/assets/js/[name].min.js"
    },

    externals: {
        'jquery': 'jQuery'
    },

    resolve: {
        extensions        : ["", ".js", ".jsx"],
        modulesDirectories: [
            path.resolve(__dirname, 'src/jbzoo/assets/js'),
            path.resolve(__dirname, 'node_modules')
        ]
    },

    devtool: isDev ? "source-map" : false,
    debug  : isDev,

    watchOptions: {
        aggregateTimeout: 100
    },

    module: {
        loaders: [
            {
                test  : /\.jsx$/,
                loader: 'babel-loader',
                query : {
                    presets: ['es2015', 'react']
                }
            }
        ]
    },

    plugins: pluginList
};
