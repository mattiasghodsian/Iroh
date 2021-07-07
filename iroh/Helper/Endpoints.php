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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class Endpoints
{
    private $actions;
    private $handler;

    public function __construct()
    {
        $this->handler = new Handler;
    }

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

            //Throw exception instead of return here
            return $errors;
        } else {
            return $args;
        }
    }

}
