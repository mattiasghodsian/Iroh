<?php

/**
 * Template routing
 * 
 * @package Iroh_Template
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

class Template {

    private $post_Type;
    protected $query;

    public function __construct()
    {
        global $wp_query;
        $this->query = $wp_query;
        $this->post_Type = get_post_type();
    }

    /**
     * Routes to templates/{type}.php
     * 
     * @return void
     */
    public function route()
    {
        $type = $this->type();
        $this->exists(APP_PATH . "templates/$type.php");
        get_template_part("templates/$type");
    }

    /**
     * Routes single posts to templates/single/{post-type}.php
     * 
     * @return void
     */
    public function single()
    {
        $this->exists(APP_PATH . "templates/single/$this->post_Type.php");
        get_template_part("templates/single/$this->post_Type");
    }

    public function archive()
    {
    
        if ( $this->query->is_day ) {
            $template = $this->post_Type . '-day';
        } elseif ( $this->query->is_month ) {
            $template = $this->post_Type . '-month';
        } elseif ( $this->query->is_year ) {
            $template = $this->post_Type . '-year';
        } elseif ( $this->query->is_author ) {
            $template = 'author';
        }else{
            $template = $this->post_Type;
        }

        $this->exists(APP_PATH . "templates/archive/$template.php");
        get_template_part("templates/archive/$template");
    }

    public function taxonomy()
    {
        $taxonomy = ( $this->query->is_category ? 'category' : $this->query->query_vars['taxonomy'] );
        $this->exists(APP_PATH . "templates/taxonomy/$taxonomy.php");
        get_template_part("templates/taxonomy/$taxonomy");
    }

    /**
     * Check if files exists
     * 
     * @param string $file path to file 
     * @return void dumps an array
     */
    public function exists($file)
    {
        if ( !file_exists($file) ){
            dump([
                'message' => 'File not found',
                'file' => $file
            ]);
        }
    }

    /**
     * Detect current page type
     * 
     * @return string
     */
    public function type()
    {
        if ( $this->query->is_page ) {
            return is_front_page() ? 'front' : 'page';
        } elseif ( $this->query->is_home ) {
            return 'home';
        } elseif ( $this->query->is_single ) {
            return ( $this->query->is_attachment ) ? 'attachment' : 'single';
        } elseif ( $this->query->is_category || $this->query->is_tax ) {
            return 'taxonomy';
        } elseif ( $this->query->is_tag ) {
            return 'tag';
        } elseif ( $this->query->is_archive ) {
            return 'archive';
        } elseif ( $this->query->is_search ) {
            return 'search';
        } elseif ( $this->query->is_404 ) {
            return '404';
        }else{
            return false;
        }
    }
    
}