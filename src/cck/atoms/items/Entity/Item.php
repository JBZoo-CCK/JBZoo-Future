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

namespace JBZoo\CCK\Atom\Items\Entity;

use JBZoo\CCK\Entity\Entity;
use JBZoo\Data\JSON;

/**
 * Class Item
 */
class Item extends Entity
{
    /**
     * The id of the item
     * @var int
     */
    public $id = 0;

    /**
     * The name of the item
     * @var string
     */
    protected $_name = '';

    /**
     * The type identifier of the Item
     * @var string
     */
    protected $_type = '';

    /**
     * The alias of the item
     * @var string
     */
    protected $_alias = '';

    /**
     * The creation date of the item in mysql DATETIME format
     * @var string
     */
    protected $_created = '';

    /**
     * The last modified date of the item in mysql DATETIME format
     * @var string
     */
    protected $_modified = '';

    /**
     * The date from which the item should be published
     * @var string
     */
    protected $_publish_up = '';

    /**
     * The date up until the item should be published
     * @var string
     */
    protected $_publish_down = '';

    /**
     * The item priority. An higher priority means that an item should be shown before
     * @var int
     */
    protected $_priority = 0;

    /**
     * Item published state
     * @var int
     */
    protected $_state = 0;

    /**
     * The access level required to see this item
     * @var int
     */
    protected $_access = 0;

    /**
     * The id of the user that created the item
     * @var int
     */
    protected $_created_by = '';

    /**
     * The item parameters
     * @var JSON
     */
    protected $_params;

    /**
     * The elements of the item encoded in json format
     * @var JSON
     */
    protected $_elements;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_elements = jbdata();
        $this->_params   = jbdata();
    }
}
