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

namespace JBZoo\CCK\Entity;

use JBZoo\Data\JSON;

/**
 * Class Position
 * @package JBZoo\CCK\Entity
 */
class Position extends Entity
{

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var string
     */
    public $layout = '';

    /**
     * @var JSON
     */
    public $params;

    /**
     * @var string
     */
    protected $_tableName = 'position';

    /**
     * Position constructor.
     * @param array $rowData
     */
    public function __construct(array $rowData = [])
    {
        parent::__construct($rowData);
        $this->params = jbdata($this->params);
    }
}
