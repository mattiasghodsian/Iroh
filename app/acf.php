<?php
if (!defined('ABSPATH')) { exit; }

/**
 * ACF block
 */
$arr = [
    [
        'name'        => 'example',
        'title'       => __('Example', APP_DOMAIN),
        'description' => __('Example description', APP_DOMAIN),
        'mode'        => 'edit',
    ],
];
acfblock()->add($arr);