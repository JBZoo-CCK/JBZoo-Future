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

var React                = require('react');
var ReactDOM             = require('react-dom');
var injectTapEventPlugin = require('react-tap-event-plugin');

import Main from './Main'; // Our custom react component

// Needed for onTouchTap
injectTapEventPlugin();

// Render the main app react component into the app div.
// For more details see: https://facebook.github.io/react/docs/top-level-api.html#react.render
if (document.getElementById('jbzoo-react-app')) {
    ReactDOM.render(<Main />, document.getElementById('jbzoo-react-app'));
}
