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

namespace JBZoo\CCK\Atom;

use JBZoo\CCK\AppAware;

/**
 * Class Atom
 * @package JBZoo\CCK
 */
abstract class Helper extends AppAware
{
    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var string
     */
    protected $_id;

    /**
     * Helper of Atom constructor.
     * @param Atom   $atom
     * @param string $helperName
     */
    public function __construct(Atom $atom, $helperName)
    {
        parent::__construct();

        $this->atom = $atom;
        $this->_id  = strtolower($this->atom->getId() . '.' . $helperName);

        $this->_init();

        $this->app->trigger('helper.init.' . $this->_id);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Pseudo constructor
     */
    protected function _init()
    {
        // noop
    }
}
