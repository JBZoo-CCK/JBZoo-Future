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

var gulp         = require('gulp'),
    uglify       = require('gulp-uglify'),
    filter       = require('gulp-filter'),
    babel        = require('gulp-babel'),
    debug        = require('gulp-debug'),
    stylus       = require('gulp-stylus'),
    gulpIf       = require('gulp-if'),
    rename       = require('gulp-rename'),
    util         = require('gulp-util'),
    autoprefixer = require('gulp-autoprefixer'),
    isDev        = !process.env.JBZOO_DEV || process.env.JBZOO_DEV == 'dev',
    //prefixTarget = 'src/jbzoo/atoms/assets-',
    prefixTarget = 'build/assets/',
    atomMap      = {
        'jquery'   : [
            'bower_components/jquery/dist/jquery.js'
        ],
        'jquery-ui': [
            'bower_components/jqueryui/jquery-ui.js'
        ],
        'bootstrap': [
            'bower_components/bootstrap/dist/js/bootstrap.js',
            'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.eot',
            'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.svg',
            'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.ttf',
            'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.woff',
            'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.woff2',
            'bower_components/bootstrap/dist/css/bootstrap.css'
        ],
        'react'    : [
            'bower_components/react/react.js',
            'bower_components/react/react-dom.js'
        ],
        'uikit'    : [
            'bower_components/uikit/css/uikit.css',
            'bower_components/uikit/fonts/FontAwesome.otf',
            'bower_components/uikit/fonts/fontawesome-webfont.ttf',
            'bower_components/uikit/fonts/fontawesome-webfont.woff',
            'bower_components/uikit/fonts/fontawesome-webfont.woff2',
            'bower_components/uikit/js/uikit.js'
        ]
    },
    assetsTypes  = {
        css   : '**/*.css',
        less  : '**/*.less',
        js    : '**/*.{js,jsx}',
        fonts : '**/{fonts,font}/*.*',
        images: '**/*.{png,jpg,jpeg,gif,svg}'
    };



gulp.task('update:jquery', function () {

    return gulp.src(files)
        .pipe(filter(pattern));

});


gulp.task('update', function (callback) {

    for (var atomName in atomMap) {
        var files = atomMap[atomName];

        for (var assetsType in assetsTypes) {
            var pattern = assetsTypes[assetsType];

            gulp.src(files)


                .pipe(filter(pattern))
                .pipe(debug({title: 'before.' + atomName + '.' + assetsType}))
                .pipe(gulpIf(assetsType == 'less', stylus()))
                .pipe(gulpIf(assetsType == 'css', autoprefixer()))
                .pipe(babel({
                    presets: ['es2015']
                }))
                .pipe(gulpIf(assetsType == 'js', uglify()))
                .pipe(rename({suffix: '.min'}))
                .pipe(debug({title: 'after.' + atomName + '.' + assetsType}))

                .pipe(gulp.dest(prefixTarget + atomName + '/assets/' + assetsType));
        }
    }

    callback();
});
