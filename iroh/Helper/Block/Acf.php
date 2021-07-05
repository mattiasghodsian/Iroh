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
    public function __construct(){
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
    private function render($block){
        $slug = str_replace('acf/', '', $block['name']);

        if (file_exists(IROH_PATH."/template-parts/acf-blocks/block-{$slug}.php")) {
            include (IROH_PATH."/template-parts/acf-blocks/block-{$slug}.php");
        }
    }

    /**
     * Add blocks
     * 
     * @since 1.0
     * @return void
     */
    public function add($array){
        $this->blocks = $array;
    }

    /**
     * Register blocks
     * 
     * @since 1.0
     * @return void
     */
    public function register(){
        // $blocks = [
        //     [
        //         'name'              => 'example',
        //         'title'             => __('Example', 'iroh'),
        //         'description'       => __('Example description', 'iroh'),
        //         'render_callback'   => [$this, 'render'],
        //         'mode'              => 'edit'
        //     ]
        // ];

        foreach ($this->blocks as $key => $block) {
            $block['render_callback'] = [$this, 'render'];
            acf_register_block($block);
        }
    }
}