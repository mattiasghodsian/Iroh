<?php

/**
 * This Helper class simplifys adding taxonomy
 *
 * @package Iroh_Taxonomy
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

use Helper\Arr\Handler;
use Helper\Theme\PostType;

class Taxonomy extends PostType
{

    /**
     * @var array $taxonomies
     * @var class $handler
     */
    protected $taxonomies;
    protected $handler;

    public function __construct()
    {
        $this->handler    = new Handler;
        $this->taxonomies = [];
        add_action('init', [$this, 'register']);
    }

    /**
     * Registers the taxonomy
     *
     */
    public function register()
    {
        if (!empty($this->taxonomies)) {
            foreach ($this->taxonomies as $taxonomy) {
                $plural   = $this->getNamePlural($this->handler->data_get($taxonomy, 'name'));
                $singular = $this->handler->data_get($taxonomy, 'name');
                $postType = $this->getNamePlural($this->handler->data_get($taxonomy, 'postTypeName'));
                $labels   = array_merge(
                    [
                        'name'              => $plural,
                        'singular_name'     => $singular,
                        'search_items'      => sprintf('Search %s', $plural),
                        'all_items'         => sprintf('All %s', $plural),
                        'parent_item'       => sprintf('Parent %s', $singular),
                        'parent_item_colon' => sprintf('Parent %s:', $singular),
                        'edit_item'         => sprintf('Edit %s', $singular),
                        'update_item'       => sprintf('Update %s', $singular),
                        'add_new_item'      => sprintf('Add New %s', $singular),
                        'new_item_name'     => sprintf('New %s Name', $singular),
                        'menu_name'         => $singular,
                    ],
                    $this->handler->data_get($taxonomy, 'labels')
                );
                $args = array_merge(
                    [
                        'label'             => $plural,
                        'labels'            => $labels,
                        'public'            => true,
                        'show_ui'           => true,
                        'show_in_nav_menus' => true,
                        '_builtin'          => false,
                    ],
                    $this->handler->data_get($taxonomy, 'args')
                );

                register_taxonomy(
                    strtolower($plural),
                    strtolower($postType),
                    $args
                );
            }
        }

    }

    /**
     * Add Taxonomy
     *
     * @param string $name
     * @param array $labels
     * @param array $args
     * @param string $postTypeName
     * @return void
     */
    public function addTax(
        string $name,
        array $labels,
        array $args,
        string $postTypeName
    ) {
        if (!taxonomy_exists($name)) {
            $this->taxonomies[] = [
                'name'         => $name,
                'labels'       => $labels,
                'args'         => $args,
                'postTypeName' => $postTypeName,
            ];
        }
    }
}
