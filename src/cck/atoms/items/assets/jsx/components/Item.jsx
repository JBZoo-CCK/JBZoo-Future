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

import React, { Component, PropTypes } from 'react';

const style = {
    color       : 'gray',
    border      : '1px dashed gray',
    padding     : '.5em 1em',
    marginTop   : '.25em',
    marginBottom: '.25em'
};

const propTypes = {
    isDragging: PropTypes.bool.isRequired,
    text      : PropTypes.string.isRequired
};

export function Item(props) {
    const { text, isDragging } = props;
    const opacity = isDragging ? 0 : 1;

    return (
        <div style={{ ...style, opacity }}>
            {text}
        </div>
    );
}

Item.propTypes = propTypes;

export function createItem(getItem, isDragging, index) {
    const item = getItem(index);
    return <Item text={item.text} isDragging={isDragging} />;
}
