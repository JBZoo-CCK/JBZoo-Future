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

var gulp       = require('gulp'),
    mainFiles  = require('main-bower-files'),
    uglify     = require('gulp-uglify'),
    rename     = require('gulp-rename'),
    jbzooAtoms = 'src/jbzoo/atoms/assets-',
    dump       = console.log;

// Task: JBZoo Utils
gulp.task('update:jbzoo-utils', function () {
    return gulp
        .src(mainFiles({filter: '**/jbzoo-utils/**/*.*'}))
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(rename({
            basename: 'jbzoo-utils',
            suffix  : '.min'
        }))
        .pipe(gulp.dest(jbzooAtoms + 'jbzoo-utils/assets/js'));
});

// Task: ReactJS
gulp.task('update:react', function () {
    return gulp
        .src([
            'bower_components/react/react.min.js',
            'bower_components/react/react-dom.min.js'
        ])
        .pipe(gulp.dest(jbzooAtoms + 'react/assets/js'));
});

// Task: UIkit CSS Framework
gulp.task('update:uikit', function () {
    gulp.src(mainFiles({filter: '**/uikit/fonts/*.*'}))
        .pipe(gulp.dest(jbzooAtoms + 'uikit/assets/fonts'));

    gulp.src(mainFiles({filter: '**/uikit/**/*.js'}))
        .pipe(gulp.dest(jbzooAtoms + 'uikit/assets/js'));

    gulp.src(mainFiles({filter: '**/uikit/**/*.css'}))
        .pipe(gulp.dest(jbzooAtoms + 'uikit/assets/css'));

    return gulp;
});

// Task: Bootstrap
gulp.task('update:bootstrap', function () {

    var source = 'bower_components/bootstrap/dist';

    gulp.src(source + '/fonts/*.*')
        .pipe(gulp.dest(jbzooAtoms + 'bootstrap/assets/fonts'));

    gulp.src(source + '/js/bootstrap.min.js')
        .pipe(gulp.dest(jbzooAtoms + 'bootstrap/assets/js'));

    gulp.src(source + '/css/bootstrap.min.css')
        .pipe(gulp.dest(jbzooAtoms + 'bootstrap/assets/css/'));
});

// Task: Update all
gulp.task('update', [
    'update:react',
    'update:jbzoo-utils',
    'update:uikit',
    'update:bootstrap'
]);
