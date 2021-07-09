<?php
if (!defined('ABSPATH')) {exit;}

/**
 * ACF block
 */
$arr = [
    [
        'name'        => 'example',
        'title'       => __('Example', 'iroh'),
        'description' => __('Example description', 'iroh'),
        'mode'        => 'edit',
    ],
];
$acfBlock = new \Helper\Block\Acf();
$acfBlock->add($arr);

/**
 * Enqueue scripts
 */
$theme = new \Helper\Theme\Enqueue();

$theme->add([
    'name'    => 'iroh',
    'path'    => get_stylesheet_uri(),
    'version' => wp_get_theme()->get('Version'),
]);

$theme->add([
    'name'    => 'app',
    'path'    => IROH_URI . 'assets/app.css',
    'version' => '1.0.0',
]);

$theme->add([
    'name'    => 'app',
    'path'    => IROH_URI . 'assets/app.js',
    'version' => '1.0.0',
], true);

$theme->add_rewrite([
    'slug'        => 'concatemoji',
    'pattern'     => '/wp(((?!include).)*)include/is',
    'replacement' => 'app',
    'style'       => false,
]);

/**
 * Array handler
 */
$target = [
    'name' => [
        'firstname' => 'John',
        'lastname'  => 'Doe',
    ],
    'age'  => 30,
    'kids' => [
        [
            'name' => [
                'firstname' => 'Iroh',
                'lastname'  => 'Git',
            ],
            'age'  => 12,
        ],
        [
            'name' => [
                'firstname' => 'Git',
                'lastname'  => 'hub',
            ],
            'age'  => 22,
        ],
    ],
];
// $arr_handler = new \Helper\Arr\Handler();
// dump( $arr_handler->data_get($target, 'kids.0.name') );

/**
 * Register cronjob task
 */
$cron = new \Helper\Cronjob();

$cron->add_recurrence([
    'key'      => 'iroh_every_thirty_min',
    'interval' => 1800,
    'display'  => __('Every 30 Minutes', 'iroh'),
]);

function test_cron()
{
    echo 'Iroh Cron';
}

$cron->add_event([
    'hook'       => 'test_cron',
    'args'       => [],
    'timestamp'  => time(),
    'recurrence' => 'iroh_every_thirty_min',
    'wp_error'   => false,
]);

// dump( $cron->registry() );
