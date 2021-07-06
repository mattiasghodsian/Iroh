<?php

/**
 * Register your custom endpoints here.
 *
 * @since 1.0.0
 * @return void
 */

use \Helper\Endpoints;

$endpoints = new Endpoints;

$endpoints->buildArray('iroh', '/iroh-route', array(
    'methods'             => 'POST',
    'callback'            => 'iroh_example_function',
    'permission_callback' => '__return_true',
))->buildArray('iroh', '/iroh-route-1', array(
    'methods'             => 'GET',
    'callback'            => 'iroh_example_function',
    'permission_callback' => '__return_true',
))->addTheActions();

function iroh_example_function()
{
    return wp_send_json('iroh', 200);
}
