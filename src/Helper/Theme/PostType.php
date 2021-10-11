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

use Helper\Arr\Handler;
use Helper\Theme\Taxonomy;

class PostType
{
    /**
     * @var array $postTypes
     * @var class $handler
     * @var string $taxonomy
     */
    protected $postTypes;
    protected $handler;
    protected $taxonomy;

    public function __construct()
    {
        $this->postTypes = [];
        $this->handler   = new Handler;
        $this->taxonomy  = new Taxonomy;

        add_action('init', [$this, 'register']);
    }

    /**
     * Registers the post type
     *
     * @return void
     */
    public function register()
    {
        if (!empty($this->postTypes)) {
            foreach ($this->postTypes as $postType) {

                $plural = $this->getNamePlural(
                    $this->handler->data_get($postType, 'name')
                );
                $singular = $this->handler->data_get($postType, 'name');
                $labels   = [
                    'name'               => $plural,
                    'singular_name'      => $singular,
                    'add_new'            => 'Add New',
                    'add_new_item'       => sprintf('Add New %s', $singular),
                    'edit_item'          => sprintf('Edit ', $singular),
                    'new_item'           => sprintf('New ', $singular),
                    'all_items'          => sprintf('All %s', $plural),
                    'view_item'          => sprintf('View %s', $singular),
                    'search_items'       => sprintf('Search %s', $plural),
                    'not_found'          => sprintf('No %s found', $singular),
                    'not_found_in_trash' => sprintf('No %s found in Trash', $singular),
                    'parent_item_colon'  => '',
                    'menu_name'          => $singular,
                ];
                $args = [
                    'labels'      => array_merge(
                        $labels,
                        $this->handler->data_get($postType, 'labels')
                    ),
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

                register_post_type(
                    strtolower($plural),
                    array_merge($args, $this->handler->data_get($postType, 'args'))
                );
            }
        }

    }

    /**
     * Add post type
     *
     * @param string $name
     * @param array $labels
     * @param array $args
     * @return void
     */
    public function add(string $name, array $labels, array $args)
    {
        if (!post_type_exists($name)) {
            $this->postTypes[] = [
                'name'   => $name,
                'labels' => $labels,
                'args'   => $args,
            ];
        }
    }

    /**
     * Adds taxonomy to the post type
     *
     * @param string $taxonomyName
     * @param array $labels
     * @param array $args
     * @param string $postTypeName
     * @return void
     */
    public function addTaxonomy(
        string $taxonomyName,
        array $labels,
        array $args,
        string $postTypeName
    ) {
        $this->taxonomy->addTax(
            $taxonomyName,
            $labels,
            $args,
            $postTypeName
        );
    }

    /**
     * Return Custom post type name in plural
     *
     * @param string $name
     * @return string
     */
    public function getNamePlural($name)
    {
        return $name . 's';
    }

}
