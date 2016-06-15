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
    source  = config.path.bower + '/jquery.browser/dist',
    atoms   = config.path.atoms;

gulp.task('update:jquery-browser', function () {
    return gulp
        .src(source + '/jquery.browser.min.js')
        .pipe(gulp.dest(atoms + 'jquery-browser/assets/js'));
});
