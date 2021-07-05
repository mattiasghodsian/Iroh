<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * ACF block
 */
$arr = [
    [
        'name'              => 'example',
        'title'             => __('Example', 'iroh'),
        'description'       => __('Example description', 'iroh'),
        'mode'              => 'edit'
    ]
];
$acfBlock = new \Helper\Block\Acf();
$acfBlock->add($arr);



/**
 * Enqueue scripts
 */
$theme = new \Helper\Theme\Enqueue();

$theme->add([
    'name'      => 'iroh', 
    'path'      => get_stylesheet_uri(),
    'version'   => wp_get_theme()->get( 'Version' ) 
]);

$theme->add([
    'name'      => 'app', 
    'path'      => IROH_URI . 'assets/app.css',
    'version'   => '1.0.0',
]);

$theme->add([
    'name'      => 'app', 
    'path'      => IROH_URI . 'assets/app.js',
    'version'   => '1.0.0',
]);