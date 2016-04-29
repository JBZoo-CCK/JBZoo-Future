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

let initialState = window.JBZOO_INITIAL_STATE ? window.JBZOO_INITIAL_STATE : {};

export let routes   = initialState.routes   ? initialState.routes   : {};
export let states   = initialState.states   ? initialState.states   : {};
export let defines  = initialState.defines  ? initialState.defines  : {};
export let sidebar  = initialState.sidebar  ? initialState.sidebar  : [];
export let atoms    = initialState.atoms    ? initialState.atoms    : [];

initialState.isLoading = false;

export default initialState;
