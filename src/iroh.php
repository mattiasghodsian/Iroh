<?php

/**
 * Register Iroh Helpers as functions
 * 
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

if ( !defined('ABSPATH') ) { 
    exit;
}

if ( !function_exists('endpoints') ){
    function endpoints()
    {
        return new \Helper\Endpoints();
    }
}

if ( !function_exists('enqueue') ){
    function enqueue()
    {
        return new \Helper\Theme\Enqueue();
    }
}

if ( !function_exists('cronjob') ){
    function cronjob()
    {
        return new \Helper\Cronjob();
    }
}

if ( !function_exists('posttype') ){
    function posttype()
    {
        return new \Helper\Theme\PostType();
    }
}

if ( !function_exists('arr') ){
    function arr()
    {
        return new \Helper\Arr\Handler();
    }
}

if ( !function_exists('acfblock') ){
    function acfblock()
    {
        if ( !in_array("advanced-custom-fields/acf.php", get_option("active_plugins")) && !function_exists('acf_register_block') ) {
            wp_die(
                "Error locating <b>acf_register_block</b> function, Activate <b>Advanced Custom Fields</b> Plugin.",
                "iroh"
            );
        }
        return new \Helper\Block\Acf();
    }
}

if ( !function_exists('main_class') ){
    function main_class(){
        if ( has_filter( 'main_class' ) ){
            $class = "";
            $class = apply_filters('main_class', $class);
            echo 'class="'.$class.'"';
        }
    }
}