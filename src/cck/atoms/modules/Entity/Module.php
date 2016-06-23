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

namespace JBZoo\CCK\Atom\Modules\Entity;

use JBZoo\CCK\Entity\Entity;

/**
 * Class Module
 *
 * @package JBZoo\CCK\Atom\Modules\Entity
 */
class Module extends Entity
{
    /**
     * The id of the item.
     *
     * @var int
     */
    public $id = 0;

    /**
     * The name of the module.
     *
     * @var string
     */
    public $title = '';

    /**
     * The module parameters.
     *
     * @var string
     */
    public $params = '';
}
