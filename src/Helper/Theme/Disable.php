<?php

/**
 * Disable WP parts
 * 
 * @package Iroh_Disable
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

class Disable {

    /**
     * Disable everything
     * 
     * @return void
     */
    public function all()
    {
        $this->emojis();
        $this->feeds();
        $this->comments();
    }

    /**
     * Disable emoji
     * 
     * @return void
     */
    public function emojis() 
    {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );	
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
        add_filter( 'tiny_mce_plugins', function ( $plugins )
        {
            if ( is_array( $plugins ) ) {
                return array_diff( $plugins, array( 'wpemoji' ) );
            } else {
                return array();
            }
        });
    }

    /**
     * Disables RSS, RDF & Atom feeds
     * 
     * @return void
     */
    public function feeds()
    {   
        add_action( 'do_feed',      [$this,'redirect'], -1 );
        add_action( 'do_feed_rdf',  [$this,'redirect'], -1 );
        add_action( 'do_feed_rss',  [$this,'redirect'], -1 );
        add_action( 'do_feed_rss2', [$this,'redirect'], -1 );
        add_action( 'do_feed_atom', [$this,'redirect'], -1 );
        add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
        remove_action( 'wp_head', 'feed_links',       2 );
        remove_action( 'wp_head', 'feed_links_extra', 3 );
    }

    /**
     * Disable Comments
     * 
     * @return void
     */
    public function comments()
    {        
        add_action( 'do_feed_rss2_comments', [$this,'redirect'], -1 );
        add_action( 'do_feed_atom_comments', [$this,'redirect'], -1 );
        add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
        add_filter('comments_open', '__return_false', 20, 2);
        add_filter('pings_open', '__return_false', 20, 2);
        add_filter('comments_array', '__return_empty_array', 10, 2);

        // Page in admin menu
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        // Links from admin bar
        add_action('init', function () {
            if (is_admin_bar_showing()) {
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            }
        });

        add_action('admin_init', function () {
            global $pagenow;
            
            if ($pagenow === 'edit-comments.php') {
                wp_redirect(admin_url());
                exit;
            }
        
            // Remove rom dashboard
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        
            // Disable support post types
            foreach (get_post_types() as $post_type) {
                if (post_type_supports($post_type, 'comments')) {
                    remove_post_type_support($post_type, 'comments');
                    remove_post_type_support($post_type, 'trackbacks');
                }
            }
        });
    }

    /**
     * Redirect to home page
     * 
     * @return void
     */
    public function redirect() 
    {
        wp_redirect( home_url() );
        die;
    }

}