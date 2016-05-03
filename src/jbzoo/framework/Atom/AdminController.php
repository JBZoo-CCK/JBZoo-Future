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

/**
 * Class AdminController
 * @package JBZoo\CCK
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        // TODO: Check cuurent user. Should be admin
    }

    /**
     * @param array $data
     * @param bool  $result
     */
    protected function _json($data = [], $result = true)
    {
        $this->app['response']->json($data, $result);
    }
}
