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
var nightmare = Nightmare({show: false});

// Auth info
const AUTH = process.env.HTTP_USER ? (process.env.HTTP_USER + ':' + process.env.HTTP_PASS + '@') : '';

console.log(process.env);

// Joomla
const JOOMLA_HOST = process.env.JOOMLA_HOST ? JOOMLA_HOST : 'cck-joomla.jbzoo';
const JOOMLA_SITE = 'http://' + AUTH + JOOMLA_HOST + '/';
const JOOMLA_ADMIN = JOOMLA_SITE + 'administrator/index.php';
const JOOMLA_PATH = JOOMLA_SITE + 'administrator/index.php?option=com_jbzoo';

// Wordpress
const WP_HOST = process.env.WP_HOST ? WP_HOST : 'cck-wordpress.jbzoo';
const WP_SITE = 'http://' + AUTH + WP_HOST + '/';
const WP_ADMIN = WP_SITE + 'wp-admin/';
const WP_PATH = WP_SITE + 'wp-admin/admin.php?page=jbzoo';


// Run tests
nightmare
    .goto(JOOMLA_ADMIN)
    .viewport(1600, 900)
    .type('[name=username]', 'admin')
    .type('[name=passwd]', 'admin')
    .click('.btn-primary')
    .wait('.admin-logo')
    .screenshot('./build/screenshot/joomla-admin-index.png')

    .goto(JOOMLA_PATH + '#atoms')
    .wait(5000)
    .screenshot('./build/screenshot/joomla-admin-atoms.png')

    .end()
    .catch(function (error) {
        console.error('Error message: ', error);
    });
