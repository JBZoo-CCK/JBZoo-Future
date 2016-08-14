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

const __DEV__ = process.env.NODE_ENV === 'development';

var webpack       = require('webpack'),
    path          = require('path'),
    glob          = require('glob'),
    ExtractPlugin = require('extract-text-webpack-plugin'),
    sourceMap     = __DEV__ ? "source-map" : false,

    entries       = function (globPath, basepath) {
        var files = glob.sync(globPath);
        var entries = {};

        basepath = path.normalize('/' + basepath);

        for (var i = 0; i < files.length; i++) {
            var entry = path.normalize('/' + files[i]);
            entry = entry.replace(basepath, '');
            var parts = entry.split(path.sep);

            entries[parts[1]] = './'+path.normalize('\\' + entry);
        }

        return entries;
    }('src/cck/atoms/**/atom.jsx', 'src/cck/atoms'),

    pluginList    = [
        new webpack.optimize.CommonsChunkPlugin({
            name     : "assets-common",
            minChunks: 2
        }),
        new ExtractPlugin('assets-common/assets/css/assets-common.min.css', {allChunks: true}),
        new webpack.DefinePlugin({
            "__DEV__": __DEV__
        })
    ];

console.log('Dev mode:', __DEV__);
console.log('Source map:', sourceMap);
console.log('Entries list:', JSON.stringify(entries, null, 4));

if (!__DEV__) {
    pluginList.push(
        new webpack.optimize.OccurenceOrderPlugin(),
        new webpack.optimize.UglifyJsPlugin({
            compress: {warnings: false},
            output  : {comments: __DEV__}
        }),
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
    context  : path.resolve(__dirname, 'src/cck/atoms'),
    entry    : entries,
    output   : {
        path    : path.resolve(__dirname, 'src/cck/atoms'),
        filename: "[name]/assets/js/[name].min.js"
    },
    externals: {
        'jquery': 'jQuery'
    },
    resolve  : {
        extensions        : ["", ".js", ".jsx"],
        modulesDirectories: [
            path.resolve(__dirname, 'src/cck/assets/jsx'),
            path.resolve(__dirname, 'node_modules')
        ]
    },
    devtool  : sourceMap,
    debug    : __DEV__,
    plugins  : pluginList,
    module   : {
        loaders: [
            {
                test  : /\.jsx$/,
                loader: 'babel-loader',
                query : {
                    presets: ['es2015', 'react', 'stage-0', 'stage-1']
                }
            },
            {
                test   : /\.css$/,
                loader : ExtractPlugin.extract('css?modules'),
                include: /flexboxgrid/
            }
        ]
    }
};
