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

// Based on https://github.com/rackt/redux/issues/37#issue-85098222
module.exports = class ReducerRegistry {
    constructor(initialReducers = {}) {
        this._reducers = {...initialReducers};
        this._emitChange = null
    }

    register(newReducers) {
        this._reducers = {...this._reducers, ...newReducers};

        if (this._emitChange != null) {
            this._emitChange(this.getReducers())
        }
    }

    getReducers() {
        return {...this._reducers}
    }

    setChangeListener(listener) {
        if (this._emitChange != null) {
            throw new Error('Can only set the listener for a ReducerRegistry once.')
        }

        this._emitChange = listener
    }
};
