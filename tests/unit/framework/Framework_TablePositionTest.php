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

use JBZoo\CCK\Table\Position;

/**
 * Class Framework_TablePositionTest
 * @package JBZoo\PHPUnit
 */
class Framework_TablePositionTest extends JBZooPHPUnit
{

    public function testClassName()
    {
        isClass('\JBZoo\CCK\Table\Position', $this->_table());
        isSame('#__jbzoo_positions', JBZOO_TABLE_POSITIONS);
    }

    public function testGetByLayout()
    {
        /** @var \JBZoo\CCK\Entity\Position $entity */
        $entity = $this->_table()->getByLayout('item.test');

        isClass('\JBZoo\CCK\Entity\Position', $entity);
        isClass('\JBZoo\Data\JSON', $entity->params);
        isTrue($entity->params->get('title'));
    }

    /**
     * @return Position
     */
    protected function _table()
    {
        return $this->app['models']['position'];
    }
}
