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
import Table from 'material-ui/lib/table/table';
import TableHeaderColumn from 'material-ui/lib/table/table-header-column';
import TableRow from 'material-ui/lib/table/table-row';
import TableHeader from 'material-ui/lib/table/table-header';
import TableRowColumn from 'material-ui/lib/table/table-row-column';
import TableBody from 'material-ui/lib/table/table-body';

import IconOn from 'material-ui/lib/svg-icons/navigation/check';
import IconOff from 'material-ui/lib/svg-icons/navigation/close';

const TableExampleSimple = () => (
    <Table>
        <TableHeader>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Name</TableHeaderColumn>
                <TableHeaderColumn>Status</TableHeaderColumn>
                <TableHeaderColumn>Type</TableHeaderColumn>
                <TableHeaderColumn>Author</TableHeaderColumn>
                <TableHeaderColumn>Date</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow>
                <TableRowColumn>3</TableRowColumn>
                <TableRowColumn>Item 1</TableRowColumn>
                <TableRowColumn><IconOn color="green" /></TableRowColumn>
                <TableRowColumn>Blog</TableRowColumn>
                <TableRowColumn>Super User</TableRowColumn>
                <TableRowColumn>10 / 03 / 2016</TableRowColumn>
            </TableRow>
            <TableRow>
                <TableRowColumn>4</TableRowColumn>
                <TableRowColumn>Other Item</TableRowColumn>
                <TableRowColumn><IconOff color="#a00" /></TableRowColumn>
                <TableRowColumn>Text</TableRowColumn>
                <TableRowColumn>SmetDenis</TableRowColumn>
                <TableRowColumn>05 / 03 / 2016</TableRowColumn>
            </TableRow>
            <TableRow>
                <TableRowColumn>42</TableRowColumn>
                <TableRowColumn>New item</TableRowColumn>
                <TableRowColumn><IconOn color="green" /></TableRowColumn>
                <TableRowColumn>Text</TableRowColumn>
                <TableRowColumn>SmetDenis</TableRowColumn>
                <TableRowColumn>06 / 03 / 2016</TableRowColumn>
            </TableRow>
        </TableBody>
    </Table>
);

export default TableExampleSimple;