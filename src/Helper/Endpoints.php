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

use Helper\Arr\Handler;
use Helper\ErrorHandler;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class Endpoints
{
    private $actions;
    private $handler;
    public $errorHandler;

    public function __construct()
    {
        $this->handler      = new Handler;
        $this->errorHandler = new ErrorHandler;
    }

    /**
     * Add action
     */
    public function addTheActions()
    {
        add_action('rest_api_init', function () {
            foreach ($this->actions as $action) {

                $validated = $this->validateArgs(
                    $this->handler->data_get($action, 'args')
                );

                register_rest_route(
                    $this->handler->data_get($action, 'namespace'),
                    $this->handler->data_get($action, 'route'),
                    $validated
                );

            }
        });
    }

    /**
     * Builds array of args for register_rest_route
     *
     * @param string $namespace
     * @param string $route
     * @param array $args
     * @return this
     */
    public function buildArray(string $namespace, string $route, array $args)
    {
        if (!isset($namespace) || !isset($route)) {
            return $this;
        }

        $this->actions[] = [
            'namespace' => $namespace,
            'route'     => $route,
            'args'      => $args,
        ];
        return $this;
    }

    /**
     * Validate args
     *
     * @param array $args
     * @return array $args
     */
    public function validateArgs($args)
    {
        $errors = [];

        $model = new Assert\Collection([
            'methods'             => [
                new NotBlank(),
            ],
            'callback'            => [
                new NotBlank(),
            ],
            'permission_callback' => [
                new NotBlank(),
            ],
        ]);

        $validator  = Validation::createValidator();
        $violations = $validator->validate($args, $model);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'property'   => $violation->getPropertyPath(),
                    'message'    => $violation->getMessageTemplate(),
                    'parameters' => $violation->getParameters(),
                ];
            }

            $this->errorHandler->dump($errors);
        } else {
            return $args;
        }
    }

}
