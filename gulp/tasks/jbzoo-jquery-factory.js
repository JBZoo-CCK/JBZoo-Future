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
    concate = require('gulp-concat'),
    source  = config.path.bower + '/jbzoo-jquery-factory/src',
    atoms   = config.path.atoms,
    js      = [
        source + '/widget.js',
        source + '/jbzoo.js'
    ];

gulp.task('update:jbzoo-jquery-factory', function () {
    return gulp
        .src(js)
        .pipe(concate('jbzoo-jquery-factory.min.js'))
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(gulp.dest(atoms + 'jbzoo-jquery-factory/assets/js'));
});
