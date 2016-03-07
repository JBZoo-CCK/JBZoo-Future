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


defined('_JBZOO') or die;

$loader = require __DIR__ . '/vendor/autoload.php';
$app    = App::getInstance();

$app['loader'] = $loader;
$app->init();

return $app;
