<?php

/**
 * This Helper class simplifys adding post types
 *
 * @package Iroh_PostType
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

class PostType
{

    public $name;
    public $labels;
    public $args;

    public function __construct(string $name, array $labels, array $args)
    {
        $this->name   = strtolower($name);
        $this->labels = $labels;
        $this->args   = $args;

        if (!post_type_exists($this->name)) {
            add_action('init', [$this, 'register']);
        }
    }

    /**
     * Registers the post type
     *
     */
    public function register()
    {
        //Default
        $labels = array(
            'name'               => $this->name,
            'singular_name'      => $this->name,
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New ' . $this->name,
            'edit_item'          => 'Edit ' . $this->name,
            'new_item'           => 'New ' . $this->name,
            'all_items'          => 'All ' . $this->getNamePlural(),
            'view_item'          => 'View ' . $this->name,
            'search_items'       => 'Search ' . $this->getNamePlural(),
            'not_found'          => 'No ' . $this->name . ' found',
            'not_found_in_trash' => 'No ' . $this->name . ' found in Trash',
            'parent_item_colon'  => '',
            'menu_name'          => $this->name,
        );
        $args = array(
            'labels'      => array_merge($labels, $this->labels),
            'public'      => true,
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'has_archive' => true,
        );

        register_post_type($this->name, array_merge($args, $this->args));
    }

    /**
     * Adds taxonomy to the post type
     *
     */
    private function addTaxonomy()
    {

    }

    /**
     * Return Custom post type name in plural
     *
     * @return string
     */
    private function getNamePlural()
    {
        return $this->name . 's';
    }
}
