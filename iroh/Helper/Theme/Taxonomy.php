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

use Helper\Theme\PostType;

class Taxonomy extends PostType
{

    /**
     * @var string $name
     * @var array $labels
     * @var array $args
     * @var string $postTypeName
     */
    protected $name;
    protected $labels;
    protected $args;
    protected $postTypeName;

    public function __construct(
        string $postTypeName,
        string $name,
        array $args,
        array $labels
    ) {
        $this->name         = strtolower($name);
        $this->labels       = $labels;
        $this->args         = $args;
        $this->postTypeName = $postTypeName;

        if (!post_type_exists($this->name)) {
            add_action('init', [$this, 'register']);
        }
    }

    /**
     * Registers the taxonomy
     *
     */
    public function register()
    {
        $plural = $this->getNamePlural($this->name);
        $labels = array_merge(
            [
                'name'              => $plural,
                'singular_name'     => $this->name,
                'search_items'      => sprintf('Search %s', $plural),
                'all_items'         => sprintf('All %s', $plural),
                'parent_item'       => sprintf('Parent %s', $this->name),
                'parent_item_colon' => sprintf('Parent %s:', $this->name),
                'edit_item'         => sprintf('Edit %s', $this->name),
                'update_item'       => sprintf('Update %s', $this->name),
                'add_new_item'      => sprintf('Add New %s', $this->name),
                'new_item_name'     => sprintf('New %s Name', $this->name),
                'menu_name'         => $this->name,
            ],
            $this->labels
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
            $this->args
        );

        register_taxonomy($plural, $this->postTypeName, $args);
    }
}
