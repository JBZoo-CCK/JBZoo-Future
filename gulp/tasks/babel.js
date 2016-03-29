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
    config = require('../config');

gulp.task('update:babel', function () {

    return gulp.src([
            config.path.bower + '/babel/browser.min.js'
        ])
        .pipe(gulp.dest(config.path.atoms + 'babel/assets/js'));
});
