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

import React, { Component } from 'react';
import Card         from 'material-ui/Card/Card';
import CardActions  from 'material-ui/Card/CardActions';
import CardHeader   from 'material-ui/Card/CardHeader';
import FlatButton   from 'material-ui/FlatButton';
import CardText     from 'material-ui/Card/CardText';

const {Grid, Row, Col} = require('react-flexbox-grid');
import {RadioButton, RadioButtonGroup} from 'material-ui/RadioButton';
import Paper        from 'material-ui/Paper';
import Toggle       from 'material-ui/Toggle';
import TextField    from 'material-ui/TextField';
import MenuItem     from 'material-ui/MenuItem';
import Checkbox     from 'material-ui/Checkbox';
import Divider      from 'material-ui/Divider';
import SelectField  from 'material-ui/SelectField';
import TimePicker   from 'material-ui/TimePicker';
import DatePicker   from 'material-ui/DatePicker';

import * as colors  from 'material-ui/styles/colors';

import { connect }              from 'react-redux';
import { bindActionCreators }   from 'redux';
import * as atomsActions        from './actions/index';

import _ from 'lodash';


var rowStyles = {marginBottom: "16px"};

class AtomsApp extends Component {

    constructor(props) {
        super(props);
        this.state = {
            atoms : props.atomsActions.getAtoms(),
            select: 1
        };
    }

    handleChange = (event, index, select) => this.setState({select});

    render() {

        return <Row>
            <Col md={9}>

                {_.times(2, i =>
                    <Card key={i}>
                        <CardHeader
                            title="Gravatar"
                            titleStyle={{fontSize:"16px", color:colors.lightBlue700}}
                            subtitle="Add support gravatar"
                            actAsExpander={true}
                            showExpandableButton={true}
                        />
                        <CardText expandable={true} style={{paddingTop:"0px"}}>
                            <Divider style={{width:"80%"}} />
                            <Row style={rowStyles}>
                                <Col md={2} style={{paddingTop:"42px"}}>Text field</Col>
                                <Col md={5}>
                                    <TextField
                                        name="text"
                                        hintText="What is your name?"
                                        floatingLabelText="Name"
                                    />
                                    <TextField
                                        name="text"
                                        hintText="a sda das dasd asdas d?"
                                        floatingLabelText="asd as dasd"
                                        defaultValue="Default Value"
                                    />
                                </Col>
                                <Col md={5} style={{paddingTop:"24px", color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor incididunt ut labore
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>Toggle field</Col>
                                <Col md={5}>
                                    <Toggle
                                        name="text"
                                        label="What is your name?"
                                        labelPosition="right"
                                        defaultToggled={true}
                                    />
                                    <Toggle
                                        name="text"
                                        label="What is your name asd sda sdasdasd?"
                                        labelPosition="right"
                                    />
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor incididunt ut labore
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>Checkbox field</Col>
                                <Col md={5}>
                                    <Checkbox
                                        label="Simple"
                                    />
                                    <Checkbox
                                        label="Simple asdasd"
                                        defaultChecked={true}
                                    />
                                    <Checkbox
                                        label="Simple asdasd adas dasd "
                                    />
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor incididunt ut labore
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>RadioButtonGroup field</Col>
                                <Col md={5}>
                                    <RadioButtonGroup name="shipSpeed" defaultSelected="not_light">
                                        <RadioButton
                                            value="light"
                                            label="Simple"
                                        />
                                        <RadioButton
                                            value="not_light"
                                            label="Selected by default"
                                        />
                                        <RadioButton
                                            value="ludicrous"
                                            label="Custom icon"
                                        />
                                    </RadioButtonGroup>
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor incididunt ut labore
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>Select field</Col>
                                <Col md={5}>
                                    <SelectField value={this.state.select} onChange={this.handleChange}>
                                        <MenuItem value={1} primaryText="Never" />
                                        <MenuItem value={2} primaryText="Every Night" />
                                        <MenuItem value={3} primaryText="Weeknights" />
                                        <MenuItem value={4} primaryText="Weekends" />
                                        <MenuItem value={5} primaryText="Weekly" />
                                    </SelectField>
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                    sed do eiusmod tempor incididunt ut labore
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>TimePicker field</Col>
                                <Col md={5}>
                                    <TimePicker
                                        format="24hr"
                                        hintText="24hr Format"
                                    />
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet
                                </Col>
                            </Row>
                            <Row style={rowStyles}>
                                <Col md={2}>TimePicker field</Col>
                                <Col md={5}>
                                    <DatePicker hintText="Portrait Dialog" />
                                </Col>
                                <Col md={5} style={{color:"#aaa"}}>
                                    Lorem ipsum dolor sit amet
                                </Col>
                            </Row>
                        </CardText>
                    </Card>
                )}
            </Col>
            <Col md={3}>
                <h2>asd</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                   labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                   nisi culpa qui officia deserunt mollit anim id est laborum.</p>
                <h2>asd</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                   aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                   qui officia deserunt mollit anim id est laborum.</p>
            </Col>
        </Row>;
    }
}

function mapStateToProps(state) {
    return {
        atoms: state.atoms
    };
}


function mapDispatchToProps(dispatch) {
    return {
        atomsActions: bindActionCreators(atomsActions, dispatch)
    }
}

let connectResult = connect(mapStateToProps, mapDispatchToProps)(AtomsApp);

module.exports = connectResult;
