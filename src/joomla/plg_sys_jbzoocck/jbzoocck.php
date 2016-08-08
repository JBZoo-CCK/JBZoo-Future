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
 * @codingStandardsIgnoreFile
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use JBZoo\CCK\App;
use JBZoo\CrossCMS\AbstractEvents;

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

/**
 * Class PlgSystemJBZooCCK
 */
class PlgSystemJBZooCCK extends JPlugin
{
    /**
     * @var App
     */
    protected $_app;

    /**
     * On Init CMS
     */
    public function onAfterInitialise()
    {
        define('JBZOO_PATH', 'administrator/components/com_jbzoo/cck'); // TODO: hardcode to fix dev symlinks
        define('JBZOO_AJAX_URL', JUri::root() . 'administrator/index.php?option=com_jbzoo');

        if ($initPath = realpath(JPATH_ROOT . '/' . JBZOO_PATH . '/init.php')) {
            require_once $initPath;

            $this->_app = App::getInstance();
            $this->_app->trigger(AbstractEvents::EVENT_INIT);
        } else {
            throw new Exception('JBZoo init file not found!');
        }
    }

    /**
     * Header render
     */
    public function onBeforeCompileHead()
    {
        if ($this->_app) {
            $this->_app->trigger(AbstractEvents::EVENT_HEADER);
        }
    }

    /**
     * Content handlers (for macroses)
     */
    public function onBeforeRespond()
    {
        if ($this->_app) {
            $body = JFactory::getApplication()->getBody();
            $this->_app->trigger(AbstractEvents::EVENT_SHUTDOWN, [&$body]);
            JFactory::getApplication()->setBody($body);
        }
    }
}

if (!function_exists('dump') && function_exists('jbd')) {
    /**
     * Overload Symfony dump() function
     * @return mixed
     */
    function dump()
    {
        return call_user_func_array('jbd', func_get_args());
    }
}
