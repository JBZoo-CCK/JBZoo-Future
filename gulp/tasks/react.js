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
    concat = require('gulp-concat'),
    config = require('../config');

// Task: ReactJS
gulp.task('update:react', function () {
    return gulp.src([
            config.path.bower + '/react/react.min.js',
            config.path.bower + '/react/react-dom.min.js'
        ])
        .pipe(concat('react.min.js'))
        .pipe(gulp.dest(config.path.atoms + 'react/assets/js'));
});
