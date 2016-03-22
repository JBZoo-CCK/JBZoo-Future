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

const gulp           = require('gulp');
const debug          = require('gulp-debug');
const gulpIf         = require('gulp-if');
const del            = require('del');
const mainBowerFiles = require('main-bower-files');
const isDevelopment  = !process.env.NODE_ENV || process.env.NODE_ENV == 'development';

gulp.task('TASKNAME', function () {

});

gulp.task('update', function () {
    return gulp.src(mainBowerFiles())
        .pipe(debug());
});
