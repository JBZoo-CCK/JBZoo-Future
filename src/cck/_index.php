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

use JBZoo\CCK\App;

ob_start();


require_once __DIR__ . '/init.php';

$app = App::getInstance();
$app->checkRequest();
echo $app->execute($app['request']->get('act', 'core.index.index'));
$app->trigger('jbzoo.assets');


$result = ob_get_contents();
ob_end_clean();

return $result;
