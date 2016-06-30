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

namespace JBZoo\CCK;

/**
 * Class Exception
 * @package JBZoo\CCK
 */
class Exception extends \Exception
{
    /**
     * @var array
     */
    protected $_extra = [];

    /**
     * Exception constructor.
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     * @param array     $extra
     */
    public function __construct($message, $code = 0, Exception $previous = null, $extra = [])
    {
        $this->_extra = $extra;

        if ($this->_extra) {
            $message .= PHP_EOL . ' - ' . implode(PHP_EOL . ' - ', (array)$this->_extra);
        }

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
