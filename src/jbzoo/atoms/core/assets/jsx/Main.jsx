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
import RaisedButton from 'material-ui/lib/raised-button';
import Dialog from 'material-ui/lib/dialog';
import Colors from 'material-ui/lib/styles/colors';
import FlatButton from 'material-ui/lib/flat-button';
import getMuiTheme from 'material-ui/lib/styles/getMuiTheme';
import themeDecorator from 'material-ui/lib/styles/theme-decorator';

const styles = {
    container: {
        textAlign : 'center',
        paddingTop: 50

    }
};

const muiTheme = getMuiTheme({
    accent1Color: Colors.deepOrange500
});

class Main extends React.Component {
    constructor(props, context) {
        super(props, context);
        this.handleRequestClose = this.handleRequestClose.bind(this);
        this.handleTouchTap     = this.handleTouchTap.bind(this);

        this.state = {
            open: false
        };
    }

    handleRequestClose() {
        this.setState({
            open: false
        });
    }

    handleTouchTap() {

        this.setState({
            open: true
        });
    }

    render() {
        const standardActions = (
            <FlatButton
                label="Okey"
                secondary={true}
                onTouchTap={this.handleRequestClose}
            />
        );

        return (
            <div style={styles.container}>
                <Dialog
                    open={this.state.open}
                    title="Super Secret Password"
                    actions={standardActions}
                    onRequestClose={this.handleRequestClose}
                >
                    1-2-3-4-888
                </Dialog>
                <h1>material-ui</h1>
                <h2>example project</h2>
                <RaisedButton
                    label="Super Secret Password"
                    primary={true}
                    onTouchTap={this.handleTouchTap}
                />
            </div>
        );
    }
}

export default themeDecorator(muiTheme)(Main);
