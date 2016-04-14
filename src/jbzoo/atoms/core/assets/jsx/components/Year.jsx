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

import React, { PropTypes, Component } from 'react'

export default class Year extends Component {

    onYearBtnClick(e) {
        this.props.getPhotos(+e.target.innerText)
    }

    render() {
        const { year, photos, fetching } = this.props;

        return <div>
            <p>
                <button onClick={this.onYearBtnClick.bind(this)}>2016</button>
                <button onClick={this.onYearBtnClick.bind(this)}>2015</button>
                <button onClick={this.onYearBtnClick.bind(this)}>2014</button>
            </p>
            <h3>{year}</h3>
            <p>Photos: {photos.length}.</p>
            {
                fetching ?
                    <p>loading...</p>
                    :
                    <p>You have {photos.length} photos.</p>
            }
        </div>
    }
}

Year.propTypes = {
    year     : PropTypes.number.isRequired,
    photos   : PropTypes.array.isRequired,
    getPhotos: PropTypes.func.isRequired
}
