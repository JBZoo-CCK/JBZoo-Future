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

namespace JBZoo\CCK\Exception;

/**
 * Class Exception
 * @package JBZoo\CCK
 */
class Exception extends \Exception
{
    protected $_extra = null;

    /**
     * Exception constructor.
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     * @param null           $extra
     */
    public function __construct($message, $code = 0, Exception $previous = null, $extra = null)
    {
        $this->_extra = $extra;

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->_extra;
    }
}
