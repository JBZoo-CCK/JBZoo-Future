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

var webpack           = require('webpack');
var path              = require('path');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var isDev             = process.env.NODE_ENV === 'development';
var sourceMap         = isDev ? "eval" : "source-map";

var pluginList = [
    new webpack.BannerPlugin("This file is part of the JBZoo CCK package."),
    new webpack.optimize.CommonsChunkPlugin({
        name     : "assets-common",
        minChunks: 2
    }),
    new ExtractTextPlugin('assets-common/assets/css/assets-common.min.css', {allChunks: true})
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

    devtool: isDev ? sourceMap : false,
    debug  : isDev,

    module: {
        loaders: [
            {
                test  : /\.jsx$/,
                loader: 'babel-loader',
                query : {
                    presets: ['es2015', 'react']
                }
            },
            {
                test   : /\.css$/,
                //loader : 'style!css?modules',
                loader : ExtractTextPlugin.extract('css?modules'),
                include: /flexboxgrid/
            }
        ]
    },

    plugins: pluginList
};
