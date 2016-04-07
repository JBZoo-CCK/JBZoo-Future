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

import FloatingActionButton from 'material-ui/lib/floating-action-button';
import ContentAdd from 'material-ui/lib/svg-icons/content/add';

const style = {
    margin  : 0,
    top     : 'auto',
    right   : 36,
    bottom  : 36,
    left    : 'auto',
    position: 'fixed'
};

const FloatingActionButtonList = () => (
    <div>
        <FloatingActionButton primary={true} style={style}>
            <ContentAdd />
        </FloatingActionButton>
    </div>
);

export default FloatingActionButtonList;
