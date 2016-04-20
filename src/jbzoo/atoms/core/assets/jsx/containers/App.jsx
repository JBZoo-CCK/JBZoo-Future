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

import React, {Component} from 'react';
import Paper    from 'material-ui/Paper';
import Theme    from '../misc/Theme';
import Header   from '../components/Header';
import Sidebar  from '../components/Sidebar';

const {Grid, Row, Col} = require('react-flexbox-grid');


class App extends Component {

    getChildContext() {
        return ({muiTheme: Theme});
    }

    render() {

        return (
            <div style={{marginBottom: "24px", marginTop:"8px"}}>

                <Row style={{marginBottom:"24px", marginRight:0 }}>
                    <Col md={12}>
                        <Header />
                    </Col>
                </Row>

                <Row style={{marginRight:0 }}>
                    <Col md={2}>
                        <Paper zDepth={1}>
                            <Sidebar />
                        </Paper>
                    </Col>
                    <Col md={10}>
                        <Paper zDepth={0} style={{minHeight:"200px"}}>
                            {this.props.children}
                        </Paper>
                    </Col>
                </Row>

            </div>
        );
    }
}

//the key passed through context must be called "muiTheme"
App.childContextTypes = {
    muiTheme: React.PropTypes.object
};

module.exports = App;
