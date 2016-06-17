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

var gulp      = require('gulp'),
    uglify    = require('gulp-uglify'),
    rename    = require('gulp-rename'),
    config    = require('../config'),
    source    = config.path.bower + '/tablesorter/',
    atoms     = config.path.atoms,
    cleanCSS  = require('gulp-clean-css'),
    replace   = require('gulp-replace'),
    concate   = require('gulp-concat');

var sources = {
    js: [
        source + 'jquery-latest.js',
        source + 'jquery.tablesorter.min.js'
    ],
    images: [
        source + 'themes/blue/*.{jpg,png,svg,gif,webp,ico}'
    ],
    css: [
        source + 'themes/blue/style.css'
    ]
};

var dist = {
    js: atoms + 'jquery-tablesorter/assets/js',
    css: atoms + 'jquery-tablesorter/assets/css',
    images: atoms + 'jquery-tablesorter/assets/images'
};

gulp.task('update:jquery-table-sorter', function () {
    //  Script
    gulp.src(sources.js)
        .pipe(concate('tablesorter.min.js'))
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(gulp.dest(dist.js));

    //  Images
    gulp.src(sources.images)
        .pipe(gulp.dest(dist.images));

    //  Styles
    gulp.src(sources.css)
        .pipe(concate('tablesorter.min.css'))
        .pipe(replace(/url\('?(.*)'?\)/g, "url('../images/$1')"))
        .pipe(replace("''", "'"))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(dist.css));
});
