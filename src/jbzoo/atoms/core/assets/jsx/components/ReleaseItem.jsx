import React, { Component } from 'react'

export default class ReleaseItem extends Component {
    render() {
        return (
            <div className='col-md-12'>
                11Динамическая часть адреса - {this.props.params.name}
            </div>
        )
    }
}