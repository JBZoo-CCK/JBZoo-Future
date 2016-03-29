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
    atomsPath = require('../config').path.atoms;

gulp.task('update:uikit', [
    'update:uikit:fonts',
    'update:uikit:js',
    'update:uikit:css'
]);

gulp.task('update:uikit:fonts', function () {
    return gulp.src(mainFiles({filter: '**/uikit/fonts/*.*'}))
        .pipe(gulp.dest(atomsPath + 'uikit/assets/fonts'));
});

gulp.task('update:uikit:js', function () {
    return gulp.src(mainFiles({filter: '**/uikit/**/*.js'}))
        .pipe(gulp.dest(atomsPath + 'uikit/assets/js'));
});

gulp.task('update:uikit:css', function () {
    return gulp.src(mainFiles({filter: '**/uikit/**/*.css'}))
        .pipe(gulp.dest(atomsPath + 'uikit/assets/css'));
});
