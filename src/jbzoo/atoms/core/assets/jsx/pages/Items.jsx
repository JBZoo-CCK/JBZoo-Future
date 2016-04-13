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

import React, { Component }  from 'react';

import Paper from 'material-ui/lib/paper';
import Table from '../components/Table';
import ItemsToolbar from '../components/ItemsToolbar';
import FloatingActionButtonList from '../components/FAB.jsx';

export default class PageItems extends Component {
    render() {
        return (
            <Paper zDepth={1}>
                <ItemsToolbar />
                <Table />
                <FloatingActionButtonList />
            </Paper>
        )
    }
}
