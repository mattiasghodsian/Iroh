<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * ACF block example
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