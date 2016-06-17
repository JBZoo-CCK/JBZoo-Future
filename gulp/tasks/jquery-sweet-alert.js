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

var gulp     = require('gulp'),
    config   = require('../config'),
    rename   = require('gulp-rename'),
    uglify   = require('gulp-uglify'),
    cleanCSS = require('gulp-clean-css'),
    source   = config.path.bower + '/sweetalert/',
    atoms    = config.path.atoms;

gulp.task('update:jquery-sweet-alert', function () {
    gulp
        .src(source + 'dist/sweetalert.min.js')
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(gulp.dest(atoms + 'jquery-sweet-alert/assets/js'));

    gulp.src(source + 'dist/sweetalert.css')
        .pipe(cleanCSS())
        .pipe(rename({
            basename: 'sweetalert',
            suffix: '.min'
        }))
        .pipe(gulp.dest(atoms + 'jquery-sweet-alert/assets/css'));
});
