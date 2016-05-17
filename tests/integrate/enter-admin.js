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

var Nightmare = require('nightmare');

var nightmare = Nightmare({
    //openDevTools: true,
    //show        : true
});


nightmare
    .goto('http://system:j461pv6kjf@joomla.ci.jbzoo.com/administrator/index.php')
    .viewport(1600, 900)
    .type('[name=username]', 'admin')
    .type('[name=passwd]', 'admin')
    .click('.btn-primary')
    .wait('.admin-logo')
    .screenshot('./build/screenshot/file.png')

    .goto('http:/system:j461pv6kjf@joomla.ci.jbzoo.com/administrator/index.php?option=com_jbzoo#/atoms')
    .wait(5000)
    .screenshot('./build/screenshot/file-2.png')

    .end()
    .on('console', function () {
        console.log(arguments);
    })
    .then(function (result) {
        console.log(result);
    })
    .catch(function (error) {
        console.error('Search failed:', error);
    });
