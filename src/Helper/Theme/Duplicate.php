<?php

/**
 * This Helper class adds possibility to Duplicate posts to wp-admin
 *
 * @package Iroh_Duplicate
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 3.0
 */

namespace Helper\Theme;

class Duplicate
{
    const DUPLICATE_FAILED = 'Could not duplicate post.';

    protected $current_user;

    public function __construct()
    {
        $this->current_user = wp_get_current_user();
    }

    /**
     * Register Duplicate to post types
     * 
     * @param array $postTypes ['post', 'page']
     * @return void
     */
    public function register(array $postTypes)
    {
        foreach ($postTypes as $postType) {
            add_filter($postType.'_row_actions', [$this, 'add_duplicate_post_link'], 10, 2);
        }
        add_action('admin_action_iroh_duplicate', [$this, 'iroh_duplicate']);
    }

    /**
     * Add new link to admin page/post row
     * 
     * @param mixed $actions
     * @param object $post
     * @return mixed
     */
    public function add_duplicate_post_link($actions, $post)
    {
        if (current_user_can('edit_posts')) {

            $url = sprintf(
                'admin.php?action=iroh_duplicate&post_id=%d&wp_nonce=%s',
                $post->ID,
                wp_create_nonce( 'iroh-duplicate-'.$post->ID )
            );

            $actions['duplicate'] = sprintf(
                '<a href="%s" title="%s" rel="permalink">%s</a>',
                $url,
                __('Duplicate', APP_DOMAIN),
                __('Duplicate', APP_DOMAIN)
            );
        }   
        return $actions;
    }

    /**
     * Set iron duplicate action
     * 
     * @return void
     */
    public function iroh_duplicate()
    {
        $nonce = sanitize_text_field($_REQUEST['wp_nonce']);
        $postId = sanitize_text_field($_REQUEST['post_id']);

        if (!wp_verify_nonce($nonce, 'iroh-duplicate-'.$postId) || !current_user_can('edit_posts')){
            wp_die(__('WP Nonce not valid or You don´t have access, Please try again.', APP_DOMAIN));
        }

        $this->duplicate($postId);
    }
    
    /**
     * Duplicate post
     * 
     * @param int $postID
     * @return void
     */
    protected function duplicate(int $postID)
    {
        $post = get_post($postID);

        if (!isset($post) || is_null($post)) {
            wp_die(__(self::DUPLICATE_FAILED, APP_DOMAIN));
        }

        $newPostId = wp_insert_post([
            'post_type' => $post->post_type,
            'post_title' => $post->post_title,
            'post_status' => "draft",
            'post_content' => $post->post_content,
            'post_excerpt' => $post->post_excerpt,
            'post_parent' => $post->post_parent,
            'post_password' => $post->post_password,
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_author' => $this->current_user->ID,
            'to_ping' => $post->to_ping,
            'menu_order' => $post->menu_order
        ], true);

        if (is_wp_error($newPostId)){
            wp_die(__(self::DUPLICATE_FAILED, APP_DOMAIN));
        }

        $this->postMeta($postID, $newPostId);
        wp_redirect(esc_url_raw(admin_url('edit.php?post_type='.$post->post_type)));
    }

    protected function postMeta(int $oldPostId, int $newPostId)
    {
        global $wpdb;

        $postMeta = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d",
            $oldPostId
        ));

        if (count($postMeta) != 0){

            $values = [];
            $holders = [];

            foreach ($postMeta as $meta) {
                array_push( $values, $newPostId, $meta->meta_key, $meta->meta_value);
                $holders[] = "(%d, %s, %s)";
            }

            $query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES ";
            $query .= implode( ', ', $holders);
            $sql   = $wpdb->prepare($query, $values);
            $wpdb->query( $sql );
        }
    }
}
