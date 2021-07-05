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

/**
 * Array handler
 */
$target = [
    'name' => [
        'firstname' => 'John',
        'lastname' => 'Doe',
    ],
    'age' => 30,
    'kids' => [
        [
            'name' => [
                'firstname' => 'Iroh',
                'lastname' => 'Git',
            ],
            'age' => 12,
        ],
        [
            'name' => [
                'firstname' => 'Git',
                'lastname' => 'hub',
            ],
            'age' => 22,
        ],
    ]
];
$arr_handler = new \Helper\Arr\Handler();
dump( $arr_handler->data_get($target, 'kids.0.name') );