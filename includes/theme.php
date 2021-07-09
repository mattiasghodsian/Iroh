<?php
if (!defined('ABSPATH')) {exit;}

use Helper\Theme\PostType;

// DISABLE COMMENTS
// DISABLE EMOJIS
// DISABLE OEMBED
// add_theme_support('iroh');

/**
 * iroh_setup
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 * @return void
 */
function iroh_setup()
{
    /* Load theme languages */
    load_theme_textdomain('iroh', IROH_PATH . '/languages');

    /* Add theme support */
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    /* Custom logo */
    add_theme_support(
        'custom-logo',
        [
            'height'      => 190,
            'width'       => 190,
            'flex-width'  => false,
            'flex-height' => false,
        ]
    );

    /* Register nav menus */
    register_nav_menus(
        array(
            'primary' => __('Primary', 'iroh'),
            'footer'  => __('Footer Menu', 'iroh'),
        )
    );

    /* Add post type support */
    add_post_type_support('page', 'excerpt');

}
add_action('after_setup_theme', 'iroh_setup');

/**
 * iroh_enqueue_scripts
 * Enqueue scripts.
 *
 * @since 1.0
 * @return void
 */
function iroh_enqueue_scripts()
{
    wp_enqueue_style('iroh-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
    wp_enqueue_script('iroh-js', IROH_URI . 'assets/js/iroh.js', ['jquery'], '1.0.0', true);

}
// add_action( 'wp_enqueue_scripts', 'iroh_enqueue_scripts', 20 );

/**
 * iroh_mime
 * Set mime types
 *
 * @since 1.0
 * @param array $mimes
 * @return array
 */
function iroh_mime($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'iroh_mime');

/**
 * iroh_admin_remove_page_menu
 * Remove menu items in wp admin
 *
 * @since 1.0
 * @return void
 */
function iroh_admin_remove_page_menu()
{
    //remove_menu_page( 'edit-comments.php' );
}
add_action('admin_menu', 'iroh_admin_remove_page_menu');

/**
 * iroh_get_svg
 * get content from .svg file
 *
 * @since 1.0
 * @param string $url
 * @param string $color hex
 * @return string/boolean
 */
function iroh_get_svg($url, $color = "")
{

    if (!$url) {
        return false;
    }

    $svg = file_get_contents($url);

    if ($color) {
        $svg = preg_replace('/(fill="#)[0-9a-f]*/i', 'fill="' . $color . '"', $svg);
    }

    return $svg;
}

/**
 * Register post type and taxonomy.
 * To overwrite default label and args insert items in the arrays.
 *
 */
$book = new PostType();
$book->add('Iroh', [], []);
$book->addTaxonomy('test', [], [], 'Iroh');
