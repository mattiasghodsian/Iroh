<?php
/**
 * This Helper class simplifys adding API Endpoints
 *
 * @package Iroh_Endpoints
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper;

class Endpoints
{
    private $actions;

    public function addTheActions()
    {
        add_action('rest_api_init', function () {
            foreach ($this->actions as $action) {
                register_rest_route($action['namespace'], $action['route'], $action['args']);
            }
        });
    }

    public function buildArray(string $namespace, string $route, array $args)
    {
        if (!isset($namespace) || !isset($route) || empty($args)) {
            return $this;
        }

        $this->actions[] = [
            'namespace' => $namespace,
            'route'     => $route,
            'args'      => $args,
        ];
        return $this;
    }

}
