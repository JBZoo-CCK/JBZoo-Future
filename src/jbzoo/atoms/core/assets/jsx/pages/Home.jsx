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

import React, {PropTypes, Component } from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'
import * as pageActions from '../actions/PageActions'

export default class Home extends Component {

    onYearBtnClick(e) {
        this.props.setYear(+e.target.innerText)
    }

    render() {
        const { name } = this.props.user;
        const { year, photos, fetching } = this.props.page;

        return <div>
            <h3>Current: {year} year</h3>
            <p>Hi, {name}!</p>
            <p>Your photos: {photos.length}</p>
        </div>
    }
}

function mapStateToProps(state) {
    return {
        user: state.user,
        page: state.page
    }
}

function mapDispatchToProps(dispatch) {
    return {
        pageActions: bindActionCreators(pageActions, dispatch)
    }
}


export default connect(mapStateToProps, mapDispatchToProps)(Home);
