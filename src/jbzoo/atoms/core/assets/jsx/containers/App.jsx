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
import Dropdown from 'react-materialize/lib/Dropdown';
import Button from 'react-materialize/lib/Button';
import NavItem from 'react-materialize/lib/NavItem';

const App = React.createClass({

    render() {
        return (
            <div>
                <Dropdown trigger={
                    <Button>Drop me!</Button>
                  }>
                    <NavItem>one</NavItem>
                    <NavItem>two</NavItem>
                    <NavItem divider />
                    <NavItem>three</NavItem>
                </Dropdown>
            </div>
        );
    }
});

export default App;
