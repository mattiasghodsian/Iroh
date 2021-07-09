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

use Helper\Theme\Taxonomy;

class PostType
{
    /**
     * @var string $name
     * @var array $labels
     * @var array $args
     */
    protected $name;
    protected $labels;
    protected $args;

    public function __construct(
        string $name,
        array $labels,
        array $args
    ) {
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
        $plural = $this->getNamePlural($this->name);
        $labels = [
            'name'               => $plural,
            'singular_name'      => $this->name,
            'add_new'            => 'Add New',
            'add_new_item'       => sprintf('Add New %s', $this->name),
            'edit_item'          => sprintf('Edit ', $this->name),
            'new_item'           => sprintf('New ', $this->name),
            'all_items'          => sprintf('All %s', $plural),
            'view_item'          => sprintf('View %s', $this->name),
            'search_items'       => sprintf('Search %s', $plural),
            'not_found'          => sprintf('No %s found', $this->name),
            'not_found_in_trash' => sprintf('No %s found in Trash', $this->name),
            'parent_item_colon'  => '',
            'menu_name'          => $this->name,
        ];
        $args = [
            'labels'      => array_merge($labels, $this->labels),
            'public'      => true,
            'supports'    => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'comments',
            ],
            'has_archive' => true,
        ];

        register_post_type($plural, array_merge($args, $this->args));
    }

    /**
     * Adds taxonomy to the post type
     *
     */
    public function addTaxonomy(
        string $taxonomyName,
        array $args,
        array $labels
    ) {
        new Taxonomy(
            $this->getNamePlural($this->name),
            $taxonomyName,
            $args,
            $labels
        );
    }

    /**
     * Return Custom post type name in plural
     *
     * @return string
     */
    public function getNamePlural($name)
    {
        return $name . 's';
    }
}
