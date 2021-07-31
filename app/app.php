<?php
if (!defined('ABSPATH')) { exit; }

/*
|--------------------------------------------------------------------------
| Register Iroh Helpers
|--------------------------------------------------------------------------
*/
require APP_PATH . 'src/iroh.php';

/*
|--------------------------------------------------------------------------
| Register WP Bootstrap NavWalker
|--------------------------------------------------------------------------
*/
require APP_PATH . 'vendor/wp-bootstrap/wp-bootstrap-navwalker/class-wp-bootstrap-navwalker.php';

/*
|--------------------------------------------------------------------------
| Theme setup
|--------------------------------------------------------------------------
*/
require APP_PATH . 'app/theme.php';

/*
|--------------------------------------------------------------------------
| Test new features or changes
|--------------------------------------------------------------------------
*/
if ( file_exists(APP_PATH . 'app/test.php') ) {
    require APP_PATH . 'app/test.php';
}