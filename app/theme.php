<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Register theme assets.
 *
 * @return void
 */
enqueue()->add([
    'name'    => APP_DOMAIN,
    'path'    => get_stylesheet_uri(),
    'version' => wp_get_theme()->get('Version'),
]);

enqueue()->add([
    'name'    => 'app',
    'path'    => APP_URI . 'assets/app.css',
    'version' => '1.0.0',
]);

enqueue()->add([
    'name'    => 'app',
    'path'    => APP_URI . 'assets/app.js',
    'version' => '1.0.0',
], true);

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