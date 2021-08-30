<?php

/**
 * ACF Block Helper class to simplify creating 
 * ACF Blocks for Gutenberg
 * 
 * @package Iroh_ACF_Block
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Block;

class Acf {
    private $blocks;

    /**
     * construct
     * 
     * @since 1.0
     * @return void
     */
    public function __construct()
    {
        if (function_exists('acf_register_block')) {
            add_action('init', array($this, 'register'));
        }
    }

    /**
     * Include blocks by slug
     * 
     * @since 1.0
     * @param array $block
     * @return void
     */
    public function render($block)
    {
        $slug = str_replace('acf/', '', $block['name']);
        if (file_exists(APP_PATH."templates/parts/acf-blocks/{$slug}.php")) {
            include (APP_PATH."templates/parts/acf-blocks/{$slug}.php");
        }
    }

    /**
     * Add blocks
     * 
     * @since 1.0
     * @return void
     */
    public function add(array $array)
    {
        foreach ($array as $key => $block) {
            if ( !array_key_exists( 'render_callback', $block) ) {
                $block['render_callback'] = array($this, 'render');
            }
            $this->blocks[] = $block;
        }
    }

    /**
     * Register blocks
     * 
     * @since 1.0
     * @return void
     */
    public function register()
    {
        if ( $this->blocks ){
            foreach ($this->blocks as $key => $block) {
                acf_register_block_type($block);
            }
        }
    }
}
