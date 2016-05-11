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

import React, {PropTypes, Component } from 'react'
const {Grid, Row, Col} = require('react-flexbox-grid');

import Card         from 'material-ui/Card/Card';
import CardActions  from 'material-ui/Card/CardActions';
import CardHeader   from 'material-ui/Card/CardHeader';
import FlatButton   from 'material-ui/FlatButton';
import CardText     from 'material-ui/Card/CardText';
import Divider      from 'material-ui/Divider';
import FormRow      from './FormRow';

import * as colors  from 'material-ui/styles/colors';


export default class AtomConfig extends Component {

    render() {

        var rows         = [],
            atomId       = this.props.atomId,
            atomConfig   = this.props.atomConfig,
            atomOnChange = this.props.atomOnChange,
            title        = <span>{this.props.atom.meta.name} <span style={{color:"#ccc"}}>[{atomId}]</span> </span>,
            description  = this.props.atom.meta.description;

        _.forEach(this.props.atom.config, function (rowData, key) {
            let rowId    = 'field_' + atomId + '_' + key,
                rowName  = atomId + '.' + key,
                rowValue = atomConfig[key];

            rows.push(<FormRow
                key={key}
                rowId={rowId}
                rowData={rowData}
                rowName={rowName}
                rowValue={rowValue}
                rowOnChange={atomOnChange}
            />);
        });

        return (
            <Card>
                <CardHeader
                    title={title}
                    subtitle={description}
                    titleStyle={{fontSize:"16px", color:colors.lightBlue700}}
                    actAsExpander={true}
                    showExpandableButton={true}
                />
                <CardText expandable={true} style={{paddingTop:"0px"}}>
                    <Divider style={{width:"58%", marginBottom:"16px"}} />
                    {rows}
                </CardText>
            </Card>
        );
    }

}
