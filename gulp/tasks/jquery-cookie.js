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

var gulp    = require('gulp'),
    config  = require('../config'),
    uglify  = require('gulp-uglify'),
    rename  = require('gulp-rename'),
    source  = config.path.bower + '/jquery.cookie/',
    atoms   = config.path.atoms;

gulp.task('update:jquery-cookie', function () {
    return gulp
        .src(source + 'jquery.cookie.js')
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(rename({
            basename: 'jquery.cookie',
            suffix  : '.min'
        }))
        .pipe(gulp.dest(atoms + 'jquery-cookie/assets/js'));
});
