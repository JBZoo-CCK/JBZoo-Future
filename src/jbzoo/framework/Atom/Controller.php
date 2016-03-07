<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CCK
 * @license   Proprietary http://jbzoo.com/license
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      http://jbzoo.com
 */

namespace JBZoo\CCK\Atom;

use JBZoo\CCK\AppAware;

/**
 * Class Atom
 * @package JBZoo\CCK
 */
class Controller extends AppAware
{
    /**
     * @var Atom
     */
    public $atom;

    /**
     * @param Atom $atom
     */
    public function setAtom(Atom $atom)
    {
        $this->atom = $atom;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->atom[$offset];
    }
}
