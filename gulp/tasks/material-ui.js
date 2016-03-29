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

var gulp         = require('gulp'),
    browserify   = require('browserify'),
    uglify       = require('gulp-uglify'),
    source       = require('vinyl-source-stream'),
    babelify     = require('babelify'),
    bundleLogger = require('../util/bundleLogger'),
    handleErrors = require('../util/handleErrors'),
    config       = require('../config').materialui.browserify;

gulp.task('update:material-ui', function (callback) {

    var bundleQueue = config.bundleConfigs.length;

    var browserifyThis = function (bundleConfig) {

        var bundler = browserify({
            // Required watchify args
            cache       : {},
            packageCache: {},
            fullPaths   : false,

            // Specify the entry point of your app
            entries: bundleConfig.entries,

            // Add file extentions to make optional in your requires
            extensions: config.extensions,

            // Enable source maps!
            debug: config.debug
        });

        var bundle = function () {
            // Log when bundling starts
            bundleLogger.start(bundleConfig.outputName);

            return bundler
                .bundle()

                // Report compile errors
                .on('error', handleErrors)

                // Use vinyl-source-stream to make the
                // stream gulp compatible. Specifiy the
                // desired output filename here.
                .pipe(source(bundleConfig.outputName))

                //.pipe(uglify({preserveComments: 'license'}))

                // Specify the output destination
                .pipe(gulp.dest(bundleConfig.dest))
                .on('end', reportFinished);
        };

        bundler.transform(babelify.configure());

        var reportFinished = function () {
            // Log when bundling completes
            bundleLogger.end(bundleConfig.outputName);

            if (bundleQueue) {
                bundleQueue--;
                if (bundleQueue === 0) {
                    // If queue is empty, tell gulp the task is complete.
                    // https://github.com/gulpjs/gulp/blob/master/docs/API.md#accept-a-callback
                    callback();
                }
            }
        };

        return bundle();
    };

    // Start bundling with Browserify for each bundleConfig specified
    config.bundleConfigs.forEach(browserifyThis);
});
