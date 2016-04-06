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

import React from 'react';
const {Grid, Row, Col} = require('react-flexbox-grid');

const App = React.createClass({
    render() {
        return (
            <Row>
                <Col md>1</Col>
                <Col md>2</Col>
                <Col md>3</Col>
            </Row>
        );
    }
});

export default App;
