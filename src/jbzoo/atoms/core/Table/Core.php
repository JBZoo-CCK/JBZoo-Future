<?php
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

namespace JBZoo\CCK\Atom\Core\Table;

use JBZoo\CrossCMS\AbstractDatabase;


/**
 * Class Core
 * @package JBZoo\CCK
 */
abstract class Core
{
    /**
     * @var AbstractDatabase
     */
    protected $_db;

    /**
     * Core constructor
     */
    public function __construct()
    {
        $this->_db = jbzoo('db');
    }
}
