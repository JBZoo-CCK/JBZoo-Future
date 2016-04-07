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
    mainFiles = require('main-bower-files'),
    rename    = require('gulp-rename'),
    cssmin    = require('gulp-cssmin'),
    cssWrap   = require('gulp-css-wrap'),
    atomsPath = require('../config').path.atoms;

gulp.task('update:materialize', function () {

    gulp.src(mainFiles({filter: '**/Materialize/fonts/**/*.*'}))
        .pipe(gulp.dest(atomsPath + 'materialize/assets/fonts/roboto'));

    gulp.src(mainFiles({filter: '**/Materialize/**/*.js'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(atomsPath + 'materialize/assets/js'));

    gulp.src(mainFiles({filter: '**/Materialize/**/*.css'}))
        .pipe(cssWrap({selector: '.jbzoo'}))
        .pipe(cssmin({debug:true}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(atomsPath + 'materialize/assets/css'));
});
