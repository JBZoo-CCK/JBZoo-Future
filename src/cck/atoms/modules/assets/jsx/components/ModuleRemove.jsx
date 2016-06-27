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
import { bindActionCreators }   from 'redux';
import { connect }              from 'react-redux';
import * as formActions         from '../../jsx/actions/form';

class ModuleRemove extends Component {

    componentDidMount() {
        let moduleId = this.props.params.id;
        let { removeModule } = this.props.formActions;
        removeModule(moduleId);
    }

    render() {return null}
}

ModuleRemove.contextTypes = {
    router: React.PropTypes.object
};

module.exports = connect(
    (dispatch) => ({
        formActions: bindActionCreators(formActions, dispatch)
    })
)(ModuleRemove);
