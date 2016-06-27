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

namespace JBZoo\PHPUnit;

/**
 * Class AtomAssetsJbzooJqueryFactory_Test
 * @package JBZoo\PHPUnit
 */
class AtomAssetsJbzooJqueryFactory_Test extends JBZooPHPUnit
{
    public function testJBZooJQueryFactory()
    {
        $result = $this->_request('test.index.assetsJBZooJQueryFactory');
        isContain("/jquery.js", $result->get('body'));
        isContain("/jbzoo-utils.min.js", $result->get('body'));
        isContain("/jbzoo-jquery-factory.min.js", $result->get('body'));
    }
}
