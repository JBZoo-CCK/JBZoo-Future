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

namespace JBZoo\CCK\Atom\Items\Renderer;

use JBZoo\Data\JSON;
use JBZoo\CCK\Entity\Item;
use JBZoo\CCK\Element\Element;
use JBZoo\CCK\Renderer\PositionRenderer;

/**
 * Class ItemRenderer
 * @package JBZoo\CCK\Atom\Items\Renderer
 */
class ItemRenderer extends PositionRenderer
{

    /**
     * @var Item
     */
    protected $_item;

    /**
     * {@inheritdoc}
     * @param string $position
     * @return bool
     */
    public function checkPosition($position)
    {
        foreach ($this->_getPositionConfig($position) as $index => $data) {
            /** @var Element $element */
            if ($element = $this->_item->getElement($data['id'])) {
                $data['_layout']   = $this->_layout;
                $data['_position'] = $position;
                $data['_index']    = $index;

                if ($element->hasValue(jbdata($data))) {
                    $render = true;

                    $this->app['events']->trigger('renderer.item.render.check-position', [
                        'render'  => &$render,
                        'element' => $element,
                        'params'  => $data,
                    ]);

                    if ($render) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Retrieve the elements from a position.
     * @param string $position
     * @return array
     */
    public function getPositionElements($position)
    {
        $elements = [];
        foreach ($this->_getPositionConfig($position) as $data) {
            if ($element = $this->_item->getElement($data['id'])) {
                $elements[] = $element;
            }
        }

        return $elements;
    }

    /**
     * {@inheritdoc}
     * @param string $position
     * @param array $options
     * @return string
     */
    public function renderPosition($position, array $options = [])
    {
        $output   = [];
        $style    = $this->_getPositionStyle($options);
        $elements = $this->_getRendererElements($position, $options);

        foreach ($elements as $i => $data) {
            /** @var JSON $params */
            $params = $data['params'];
            $params->set('first', ($i == 0))->set('last', ($i == count($elements) - 1));

            $output[$i] = parent::render(self::STYLES_FOLDER . '.' . $style, [
                'params'  => $params,
                'element' => $data['element'],
            ]);

            $this->app['events']->trigger('renderer.item.render.after', [
                'params'  => $params,
                'html'    => &$output[$i],
                'element' => $data['element'],
            ]);
        }

        return implode(PHP_EOL, $output);
    }

    /**
     * Set item entity.
     * @param Item $item
     * @return $this
     */
    public function setItem(Item $item)
    {
        $this->_item = $item;
        return $this;
    }

    /**
     * Get position configuration.
     * @param string $position
     * @return array
     */
    protected function _getPositionConfig($position)
    {
        $type    = $this->_item->getType();
        $configs = $this->getConfig($type->id . '.' . $this->_layout);
        return $configs->get($position, []);
    }

    /**
     * Get style of render position.
     * @param array $options
     * @return string
     */
    protected function _getPositionStyle(array $options = [])
    {
        return (isset($options['style']) && !empty($options['style'])) ? $options['style'] : self::DEFAULT_STYLE;
    }

    /**
     * Get elements for render.
     * @param string $position
     * @param array $options
     * @return array
     */
    protected function _getRendererElements($position, array $options = [])
    {
        $elements = [];
        $configs  = $this->_getPositionConfig($position);
        foreach ($configs as $index => $data) {
            /** @var Element $element */
            if ($element = $this->_item->getElement($data['id'])) {
                $data['_layout']   = $this->_layout;
                $data['_position'] = $position;
                $data['_index']    = $index;

                $params = jbdata(array_merge($data, $options));
                if ($element->hasValue($params)) {
                    $render = true;
                    $this->app['events']->trigger('renderer.item.render.before', [
                        'render'  => &$render,
                        'element' => $element,
                        'params'  => $params,
                    ]);

                    if ($render) {
                        $elements[] = ['params'  => $params, 'element' => $element];
                    }
                }
            }
        }

        return $elements;
    }
}
