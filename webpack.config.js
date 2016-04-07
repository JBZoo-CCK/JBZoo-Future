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

var webpack       = require('webpack');
var path          = require('path');
var glob          = require('glob');
var ExtractPlugin = require('extract-text-webpack-plugin');
var isDev         = process.env.NODE_ENV === 'development';
var sourceMap     = isDev ? "eval" : false;
var pluginList    = [
    new webpack.optimize.CommonsChunkPlugin({
        name     : "assets-common",
        minChunks: 2
    }),
    new ExtractPlugin('assets-common/assets/css/assets-common.min.css', {allChunks: true})
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
        new webpack.NoErrorsPlugin(),
        new webpack.BannerPlugin("This file is part of the JBZoo CCK package.")
    );
}

module.exports = {
    context: path.resolve(__dirname, 'src/jbzoo/atoms'),

    entry: function (globPath, basepath) {
        var files   = glob.sync(globPath);
        var entries = {};

        basepath = path.normalize('/' + basepath);

        for (var i = 0; i < files.length; i++) {
            var entry = path.normalize('/' + files[i]);
            entry     = entry.replace(basepath, '');
            var parts = entry.split(path.sep);

            entries[parts[1]] = './' + entry;
        }

        return entries;
    }('src/jbzoo/atoms/**/index.jsx', 'src/jbzoo/atoms'),

    output   : {
        path    : path.resolve(__dirname, 'src/jbzoo/atoms'),
        filename: "[name]/assets/js/[name].min.js"
    },
    externals: {
        'jquery': 'jQuery'
    },
    resolve  : {
        extensions        : ["", ".js", ".jsx"],
        modulesDirectories: [
            path.resolve(__dirname, 'src/jbzoo/assets/js'),
            path.resolve(__dirname, 'node_modules')
        ]
    },
    devtool  : isDev ? sourceMap : false,
    debug    : isDev,
    plugins  : pluginList,
    module   : {
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
                loader : ExtractPlugin.extract('css?modules'),
                include: /flexboxgrid/
            }
        ]
    }
};
