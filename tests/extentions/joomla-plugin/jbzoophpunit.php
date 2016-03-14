<?php
/**
 * JBZoo CrossCMS
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   CrossCMS
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/CrossCMS
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

defined('_JEXEC') or die;

/**
 * Class PlgSystemJBZooPHPUnit
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class PlgSystemJBZooPHPUnit extends JPlugin
{
    /**
     * Listner for trigger onAfterDispatch
     */
    public function onAfterDispatch()
    {
        if ($this->_request('jbzoo-phpunit')) {

            if (isset($GLOBALS['__TEST_FUNC__']) && $GLOBALS['__TEST_FUNC__'] instanceof \Closure) {
                $GLOBALS['__TEST_FUNC__']();
            } else {
                throw new Exception('__TEST_FUNC__ is not \Closure function!');
            }
        }
    }

    /**
     * @param string $valueName
     * @param mixed  $default
     * @return mixed
     * @throws Exception
     */
    protected function _request($valueName, $default = null)
    {
        $jInput = JFactory::getApplication()->input;
        $value  = $jInput->get($valueName, $default, false);

        return $value;
    }
}
