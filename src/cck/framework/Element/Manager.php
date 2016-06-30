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
use JBZoo\CCK\Exception\Exception;
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
     * Create new element instance
     *
     * @param string         $type
     * @param string         $group
     * @param array          $config
     * @param EntityElements $entity
     * @return Element
     * @throws Exception
     */
    public function create($type, $group = 'Item', $config = [], EntityElements $entity = null)
    {
        $type = ucfirst(strtolower($type));
        if (!$type) {
            throw new Exception('Element type is empty');
        }

        $group = ucfirst(strtolower($group));
        if (!$group) {
            throw new Exception('Element group is empty');
        }

        $elementClass = "\\JBZoo\\CCK\\Element\\{$group}\\{$type}";
        if (!class_exists($elementClass)) {
            throw new Exception("Element class '{$elementClass}' not found!");
        }

        /** @var Element $element */
        $element = new $elementClass($type, $group);

        $config = array_merge([
            'id'          => $element->isCore() ? '_' . strtolower($type) : Str::random(10),
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

        $element->init();

        return $element;
    }

    /**
     * Separates the passed element values with a separator
     *
     * @param string $separator
     * @param array  $values
     * @return string
     */
    public function applySeparators($separator, $values)
    {
        $values = !is_array($values) ? (array)$values : $values;

        if (null === $separator) {
            $separator = PHP_EOL . ' ';
        }

        $value = implode($separator, $values);

        return $value;
    }
}
