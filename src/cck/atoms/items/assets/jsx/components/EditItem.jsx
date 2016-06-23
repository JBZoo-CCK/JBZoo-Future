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

import React from 'react';
import Formsy from 'formsy-react';
import getMuiTheme from 'material-ui/styles/getMuiTheme'
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import Paper from 'material-ui/Paper';
import RaisedButton from 'material-ui/RaisedButton';
import MenuItem from 'material-ui/MenuItem';
import { FormsyCheckbox, FormsyDate, FormsyRadio, FormsyRadioGroup,
    FormsySelect, FormsyText, FormsyTime, FormsyToggle } from 'formsy-material-ui/lib';

const Main = React.createClass({

    getInitialState() {
        return {
            canSubmit: false,
        };
    },

    errorMessages: {
        wordsError  : "Please only use letters",
        numericError: "Please provide a number",
        urlError    : "Please provide a valid URL",
    },

    styles: {
        paperStyle : {
            width  : 300,
            margin : 'auto',
            padding: 20,
        },
        switchStyle: {
            marginBottom: 16,
        },
        submitStyle: {
            marginTop: 32,
        },
    },

    enableButton() {
        this.setState({
            canSubmit: true,
        });
    },

    disableButton() {
        this.setState({
            canSubmit: false,
        });
    },

    submitForm(data) {
        alert(JSON.stringify(data, null, 4));
    },

    notifyFormError(data) {
        console.error('Form error:', data);
    },

    render() {
        let {paperStyle, switchStyle, submitStyle } = this.styles;
        let { wordsError, numericError, urlError } = this.errorMessages;

        return (
            <Formsy.Form
                onValid={this.enableButton}
                onInvalid={this.disableButton}
                onValidSubmit={this.submitForm}
                onInvalidSubmit={this.notifyFormError}
            >
                <div>
                    <FormsyText
                        name="name"
                        validations="isWords"
                        validationError={wordsError}
                        required
                        hintText="What is your name?"
                        floatingLabelText="Name"
                    />
                </div>
                <div>
                    <FormsyText
                        name="age"
                        validations="isNumeric"
                        validationError={numericError}
                        hintText="Are you a wrinkly?"
                        floatingLabelText="Age (optional)"
                    />
                </div>
                <div>
                    <FormsyText
                        name="url"
                        validations="isUrl"
                        validationError={urlError}
                        required
                        hintText="http://www.example.com"
                        floatingLabelText="URL"
                    />
                </div>
                <div>
                    <FormsySelect
                        name="frequency"
                        required
                        floatingLabelText="How often do you?"
                        menuItems={this.selectFieldItems}
                    >
                        <MenuItem value={'never'} primaryText="Never" />
                        <MenuItem value={'nightly'} primaryText="Every Night" />
                        <MenuItem value={'weeknights'} primaryText="Weeknights" />
                    </FormsySelect>
                </div>
                <div>
                    <FormsyDate
                        name="date"
                        required
                        floatingLabelText="Date"
                    />
                </div>
                <div>
                    <FormsyTime
                        name="time"
                        required
                        floatingLabelText="Time"
                    />
                </div>
                <div>
                    <FormsyCheckbox
                        name="agree"
                        label="Do you agree to disagree?"
                        style={switchStyle}
                    />
                </div>
                <div>
                    <FormsyToggle
                        name="toggle"
                        label="Toggle"
                        style={switchStyle}
                    />
                </div>
                <div>
                    <FormsyRadioGroup name="shipSpeed" defaultSelected="not_light">
                        <FormsyRadio
                            value="light"
                            label="prepare for light speed"
                            style={switchStyle}
                        />
                        <FormsyRadio
                            value="not_light"
                            label="light speed too slow"
                            style={switchStyle}
                        />
                        <FormsyRadio
                            value="ludicrous"
                            label="go to ludicrous speed"
                            style={switchStyle}
                            disabled={true}
                        />
                    </FormsyRadioGroup>
                </div>
                <div>
                    <RaisedButton
                        style={submitStyle}
                        type="submit"
                        label="Submit"
                        disabled={!this.state.canSubmit}
                    />
                </div>
            </Formsy.Form>
        );
    }
});

module.exports = Main;
