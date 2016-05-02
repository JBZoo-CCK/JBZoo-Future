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

/* bundleLogger
 ------------
 Provides gulp style logs to the bundle method in browserify.js
 */

'use strict';

var gutil        = require('gulp-util');
var prettyHrtime = require('pretty-hrtime');
var startTime;

module.exports = {
    start: function (filepath) {
        startTime = process.hrtime();
        gutil.log('Bundling', gutil.colors.green(filepath) + '...');
    },

    end: function (filepath) {
        var taskTime   = process.hrtime(startTime);
        var prettyTime = prettyHrtime(taskTime);
        gutil.log('Bundled', gutil.colors.green(filepath), 'in', gutil.colors.magenta(prettyTime));
    }
};
