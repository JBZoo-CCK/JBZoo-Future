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

namespace JBZoo\CCK\Atom\Test\Controller;

use JBZoo\CCK\Atom\SiteController;

/**
 * Class SiteIndex
 * @package JBZoo\CCK
 */
class SiteIndex extends SiteController
{
    /**
     * Check that action return some value (not echo!)
     */
    public function checkReturn()
    {
        return 123456;
    }

    /**
     * Show uniq var from request
     */
    public function index()
    {
        echo $this->app['request']->get('uniqid');
    }

    /**
     * Add JS variable to document
     */
    public function addDocumentVariable()
    {
        $this->app['core.js']->addVar('SomeVar', 42);
    }

    public function error404()
    {
        $this->app->show404('Some 404 error message');
    }

    public function error500()
    {
        $this->app->error('Some 500 error message');
    }

    public function renderJson()
    {
        $request = $this->app['request']->get('test-data', [], 'arr');
        $this->_json($request);
    }

    public function assetsJQuery()
    {
        $this->app['assets']->add('jquery');
    }

    public function assetsJQueryUI()
    {
        $this->app['assets']->add('jquery-ui');
    }

    public function assetsJQueryBrowser()
    {
        $this->app['assets']->add('jquery-browser');
    }

    public function assetsJQueryCookie()
    {
        $this->app['assets']->add('jquery-cookie');
    }

    public function assetsJQueryEasing()
    {
        $this->app['assets']->add('jquery-easing');
    }

    public function assetsJQueryFancybox()
    {
        $this->app['assets']->add('jquery-fancybox');
    }

    public function assetsJQueryMouseWheel()
    {
        $this->app['assets']->add('jquery-mousewheel');
    }

    public function assetsJQuerySweetAlert()
    {
        $this->app['assets']->add('jquery-sweet-alert');
    }

    public function assetsBabel()
    {
        $this->app['assets']->add('babel-cdn');
    }

    public function assetsBootstrap()
    {
        $this->app['assets']->add('bootstrap');
    }

    public function assetsJBZooUtils()
    {
        $this->app['assets']->add('jbzoo-utils');
    }

    public function assetsMaterialize()
    {
        $this->app['assets']->add('materialize');
    }

    public function assetsReact()
    {
        $this->app['assets']->add('react');
    }

    public function assetsUIkit()
    {
        $this->app['assets']->add('uikit');
    }
}
