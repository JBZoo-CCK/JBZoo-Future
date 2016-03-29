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

var notify = require("gulp-notify");

module.exports = function () {

    var args = Array.prototype.slice.call(arguments);

    // Send error to notification center with gulp-notify
    notify.onError({
        title  : "Compile Error",
        message: "<%= error.message %>"
    }).apply(this, args);

    // Keep gulp from hanging on this task
    this.emit('end');
};
