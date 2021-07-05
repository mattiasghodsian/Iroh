<?php
/* Globals */
define( "IROH_PATH", get_template_directory() . '/' );
define( "IROH_URI", get_stylesheet_directory_uri() . '/' );

/* Composer */
require_once( IROH_PATH . 'vendor/autoload.php' );

/* WP Bootstrap NavWalker */
require_once( IROH_PATH . 'vendor/wp-bootstrap/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php' );

/* Includes */
require_once( IROH_PATH . 'includes/theme.php' );
require_once( IROH_PATH . 'includes/examples.php' );