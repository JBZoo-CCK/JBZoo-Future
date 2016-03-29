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

var gulp   = require('gulp'),
    config = require('../config'),
    source = config.path.bower + '/bootstrap/dist',
    atoms  = config.path.atoms;

gulp.task('update:bootstrap:fonts', function () {
    return gulp.src(source + '/fonts/*.*')
        .pipe(gulp.dest(atoms + 'bootstrap/assets/fonts'));
});

gulp.task('update:bootstrap:js', function () {
    return gulp.src(source + '/js/bootstrap.min.js')
        .pipe(gulp.dest(atoms + 'bootstrap/assets/js'));
});

gulp.task('update:bootstrap:css', function () {
    return gulp.src(source + '/css/bootstrap.min.css')
        .pipe(gulp.dest(atoms + 'bootstrap/assets/css/'));
});

gulp.task('update:bootstrap', [
    'update:bootstrap:fonts',
    'update:bootstrap:js',
    'update:bootstrap:css'
]);
