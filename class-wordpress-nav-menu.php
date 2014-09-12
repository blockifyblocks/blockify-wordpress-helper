<?php

namespace Blockify;

class WordpressMenu extends Block
{
    private $childQueue = [];

    public function __construct($menu, $args = null)
    {
        parent::__construct('core-menu');

        $wp_items = wp_get_nav_menu_items($menu, $args);

        if (!$wp_items) {
            $locations = get_nav_menu_locations();
            $wp_items = wp_get_nav_menu_items($locations[$menu], $args);
        }

        if (!$wp_items) {
            return false;
        }

        foreach ($wp_items as $item) {
            $item = WordpressMenu::createItem($item);

            // Look for queued children
            foreach ($this->childQueue as $key => $child) {
                if ($child->model['@parent'] === $item->model['@id']) {
                    unset($this->childQueue[$key]);
                    $item->appendChild($child);
                }
            }

            // Look for parent
            if ($item->model['@parent'] == 0) {
                $this->appendChild($item);
            } else {
                $this->childQueue[$item->model['@id']] = $item;
                array_walk($this->children, [$this, 'addToParent'], $item);
            }
        }
    }

    private function addToParent(&$value, $key, $item)
    {
        if ($value->model['@id'] === $item->model['@parent']) {
            unset($this->childQueue[$item->model['@id']]);
            $value->appendChild($child);
        }
        array_walk($value->children, [$this, 'addToParent'], $item);
    }

    public static function createItem($item)
    {
        return new Block('core-item', [
            '@id' => $item->ID,
            '@parent' => (int) $item->menu_item_parent,
            'name' => $item->title,
            'description' => $item->description,
            'url' => $item->url
        ]);
    }
}
