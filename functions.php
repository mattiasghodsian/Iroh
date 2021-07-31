<?php
if (!defined('ABSPATH')) { exit; }

/*
|--------------------------------------------------------------------------
| Defines a named constant at runtime.
|--------------------------------------------------------------------------
*/
define("APP_PATH", get_template_directory() . '/');
define("APP_URI", get_stylesheet_directory_uri() . '/');
define('APP_DOMAIN', 'iroh');

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
if ( !file_exists($composer = APP_PATH . 'vendor/autoload.php') ) {
    wp_die(
        __('Error locating autoloader. Run <code>composer install</code>.', APP_DOMAIN)
    );
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register Theme Files
|--------------------------------------------------------------------------
*/
require_once APP_PATH . 'app/app.php';