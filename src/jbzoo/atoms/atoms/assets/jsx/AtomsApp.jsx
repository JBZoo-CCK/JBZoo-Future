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

import React, { Component }     from 'react';
import Paper                    from 'material-ui/Paper';
import AtomConfig               from './components/Form/AtomConfig';
import AtomsToolbar             from './components/AtomsToolbar';
import { connect }              from 'react-redux';
import { bindActionCreators }   from 'redux';
import * as atomsActions        from './actions/index';
import { fetchAtomsIfNeeded }   from './actions'
import _                        from 'lodash';

const {Grid, Row, Col} = require('react-flexbox-grid');

class AtomsApp extends Component {

    componentDidMount() {
        this.props.atomsActions.fetchAtomsIfNeeded();
    }

    render() {

        var configs = this.props.config;

        if (!this.props.atomsForms) {
            return <div>Loading atoms configs...</div>
        }

        var rows = [];
        _.forEach(this.props.atomsForms, function (atomForm, key) {
            rows.push(<AtomConfig key={key} atom={atomForm} atomId={key} atomConfig={configs[`atom.${key}`]} />);
        });

        return (
            <div>
                <AtomsToolbar />
                <br />
                <Row>
                    <Col md={9}>
                        {rows}
                    </Col>
                    <Col md={3}>
                        <h2>asd</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                           labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                           laboris nisi culpa qui officia deserunt mollit anim id est laborum.</p>
                        <h2>asd asd</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                           aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                           esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                           sunt in qui officia deserunt mollit anim id est laborum.</p>
                    </Col>
                </Row>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        atomsForms: state.atomsForms,
        config    : state.config,
        isLoading : state.isLoading
    };
}

function mapDispatchToProps(dispatch) {
    return {
        atomsActions: bindActionCreators(atomsActions, dispatch)
    }
}

module.exports = connect(mapStateToProps, mapDispatchToProps)(AtomsApp);
