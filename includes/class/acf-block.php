<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Acf_Block
{
    public function __construct()
    {

        if (function_exists('acf_register_block')) {
            add_action('init', array($this, 'register'));
        }
    }

    public function render($block)
    {
        $slug = str_replace('acf/', '', $block['name']);

        if (file_exists(get_template_directory()."/template-parts/acf-blocks/block-{$slug}.php")) {
            include (get_template_directory()."/template-parts/acf-blocks/block-{$slug}.php");
        }
    }

    /**
     * register
     * Register blocks
     * 
     * @since 1.0
     * @return void
     */
    public function register()
    {
        $blocks = [
            [
                'name'              => 'example',
                'title'             => __('Example', 'iroh'),
                'description'       => __('Example description', 'iroh'),
                'render_callback'   => [this, 'render'],
                'mode'              => 'edit'
            ]
        ];

        foreach ($blocks as $key => $block) {
            acf_register_block($block);
        }
    }
}

new Acf_Block();