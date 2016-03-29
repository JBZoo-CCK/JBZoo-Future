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
    mainFiles = require('main-bower-files'),
    config    = require('../config');

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
        .pipe(gulp.dest(config.path.atoms + 'jbzoo-utils/assets/js'));
});
