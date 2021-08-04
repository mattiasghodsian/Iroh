<?php
if (!defined('ABSPATH')) { exit; }

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
acfblock()->add($arr);