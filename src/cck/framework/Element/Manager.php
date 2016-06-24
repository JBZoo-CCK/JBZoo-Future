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

namespace JBZoo\CCK\Element;

use JBZoo\CCK\App;
use JBZoo\CCK\Entity\EntityElements;
use JBZoo\Utils\Str;

/**
 * Class Manager
 */
class Manager
{
    /**
     * @var App
     */
    public $app;

    /**
     * @param string         $type
     * @param string         $group
     * @param array          $config
     * @param EntityElements $entity
     * @return Element
     */
    public function create($type, $group = 'Item', $config = [], EntityElements $entity = null)
    {
        $group = ucfirst(strtolower($group));
        $type  = ucfirst(strtolower($type));

        $elementClass = "\\JBZoo\\CCK\\Element\\{$group}\\{$type}";

        /** @var Element $element */
        $element = new $elementClass($type, $group);

        $isCore = $element->isCore();

        $config = array_merge([
            'id'          => $isCore ? '_' . strtolower($type) : Str::uuid(),
            'name'        => $element->getName(),
            'type'        => $type,
            'group'       => $group,
            'description' => '',
            'access'      => '1', // TODO: get from CrossCMS
        ], (array)$config);

        $element->id = $config['id'];
        $element->setConfig($config);

        if ($entity) {
            $element->setEntity($entity);
        }

        return $element;
    }
}
