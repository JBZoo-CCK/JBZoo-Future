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
 * @codingStandardsIgnoreFile
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use JBZoo\CCK\App;

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
        define('_JBZOO', true);

        require_once realpath(JPATH_ROOT . '/administrator/components/com_jbzoo/init.php');

        $this->_app = App::getInstance();

        //$this->_app->on('cms.init', function (App $app) {
        //    $app['path']->set('jbzoo', 'root:components/com_jbzoo');
        //});

        $this->_app->trigger('cms.init');
    }

    /**
     * Header render
     */
    public function onBeforeCompileHead()
    {
        $this->_app->trigger('cms.header');
    }

    /**
     * Content handlers (for macroses)
     */
    public function onAfterRespond()
    {
        $body = JFactory::getApplication()->getBody();
        $this->_app->trigger('cms.shutdown', [&$body]);
        JFactory::getApplication()->setBody($body);
    }
}
