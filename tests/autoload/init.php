<?php
/**
 * JBZoo CCK
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

include __DIR__ . '/php_config.php';

require_once __DIR__ . '/init_composer.php';

require_once __DIR__ . '/browser_env.php';
require_once __DIR__ . '/init_cms.php';
require_once __DIR__ . '/init_cms_' . __CMS__ . '.php';

include __DIR__ . '/php_config.php'; // Force overwrite important php configs!
