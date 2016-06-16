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
    source  = config.path.bower + '/jquery-mousewheel/',
    atoms   = config.path.atoms;

gulp.task('update:jquery-mousewheel', function () {
    return gulp
        .src(source + 'jquery.mousewheel.min.js')
        .pipe(uglify({
            preserveComments: 'license'
        }))
        .pipe(gulp.dest(atoms + 'jquery-mousewheel/assets/js'));
});
