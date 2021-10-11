<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Register theme assets.
 *
 * @return void
 */
enqueue()->add([
    'name'    => 'style',
    'path'    => get_stylesheet_uri(),
    'version' => wp_get_theme()->get('Version'),
])->add([
    'name'    => 'app',
    'path'    => APP_URI . 'assets/app.css',
    'version' => '1.0.0',
])->add([
    'name'    => 'app',
    'path'    => APP_URI . 'assets/app.js',
    'version' => '1.0.0',
]);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
function theme_setup()
{
    /* Load theme languages */
    load_theme_textdomain(APP_DOMAIN, APP_PATH . '/languages');

    /* Add theme support */
    add_theme_support('post-thumbnails');

    /* Register nav menus */
    register_nav_menus(
        array(
            'primary' => __('Primary', APP_DOMAIN),
            'footer'  => __('Footer', APP_DOMAIN),
        )
    );

    /* Add post type support */
    add_post_type_support('page', 'excerpt');

}
add_action('after_setup_theme', 'theme_setup');

/**
 * Register Upload mimes
 *
 * @param array $mimes
 * @return array
 */
function register_upload_mime($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'register_upload_mime');

/**
 * Set class for main HTML tag
 *
 * @param string $class
 * @return string
 */
add_filter('main_class', function($class){
    $class .= "container my-5";
    return $class;
});

/**
 * Fix BS4 NavWalker for BS5
 *
 * @param array $atts
 * @return array
 */
add_filter( 'nav_menu_link_attributes', 'bs5_dropdown_fix' );
function bs5_dropdown_fix( $atts ) {
    if ( array_key_exists( 'data-toggle', $atts ) ) {
        unset( $atts['data-toggle'] );
        $atts['data-bs-toggle'] = 'dropdown';
    }
    return $atts;
}

/**
 * Disable emojis
 * 
 * @return void
 */
disable_emojis();