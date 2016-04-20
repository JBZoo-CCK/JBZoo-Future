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

import Checkbox     from 'material-ui/Checkbox';

const {Grid, Row, Col} = require('react-flexbox-grid');
import Paper        from 'material-ui/Paper';
import Toggle       from 'material-ui/Toggle';
import TextField    from 'material-ui/TextField';

import _ from 'lodash';

import { FormsyCheckbox, FormsyDate, FormsyRadio, FormsyRadioGroup,
    FormsySelect, FormsyText, FormsyTime, FormsyToggle } from 'formsy-material-ui/lib';

class AtomsApp extends Component {

    render() {
        return <Row>
            <Col md={7}>

                {_.times(3, i =>
                    <Card key={i}>
                        <CardHeader
                            title="Gravatar"
                            subtitle="Add support gravatar"
                            actAsExpander={false}
                            showExpandableButton={true}
                        />
                        <CardText expandable={true}>

                            <Formsy.Form>
                                <div style={{margin:"10px"}}>
                                    <FormsyText
                                        name="name"
                                        hintText="What is your name?"
                                        floatingLabelText="Name"
                                    />
                                </div>
                                <div>
                                    <FormsyText
                                        name="age"
                                        hintText="Are you a wrinkly?"
                                        floatingLabelText="Age (optional)"
                                    />
                                </div>
                            </Formsy.Form>

                        </CardText>
                    </Card>
                )}
            </Col>
            <Col md={5}>
                <h2>asd</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                   labore
                   et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                   ut
                   aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                   culpa
                   qui officia deserunt mollit anim id est laborum.</p>
                <h2>asd</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                   labore
                   et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                   ut
                   aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                   culpa
                   qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                   labore
                   et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                   ut
                   aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                   cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                   culpa
                   qui officia deserunt mollit anim id est laborum.</p>
            </Col>
        </Row>;
    }
}

module.exports = AtomsApp;
