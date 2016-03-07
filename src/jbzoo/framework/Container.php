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

namespace JBZoo\CCK;

use Pimple\Container as PimpleContainer;

/**
 * Class Container
 * @package JBZoo\CCK
 */
class Container extends PimpleContainer
{
    /**
     * @var App
     */
    public $app;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->app = App::getInstance();
    }
}
