<?php
/* Globals */
define( "IROH_PATH", get_template_directory() . '/' );
define( "IROH_URI", get_stylesheet_directory_uri() . '/' );
define( "IROH_VERSION", '1.0.0' );

/* Composer */
require_once( IROH_PATH . 'vendor/autoload.php' );

/* Theme */
require_once( IROH_PATH . 'includes/theme.php' );