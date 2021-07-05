<?php
/**
 * This Helper class simplifys adding scripts
 * 
 * @package Iroh_Enqueue
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\NotBlank;

class Enqueue {
    
    protected $scripts = [];
    protected $styles = [];

    /**
     * construct
     * 
     * @since 1.0
     * @return void
     */
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [$this, 'load_enqueues'], 20 );   
    }

    /** 
     * load enqueued scripts.
     * 
     * @since 1.0
     * @return void
     */
    public function load_enqueues(){

        if ($this->styles){
            foreach ($this->styles as $key => $style){
                wp_enqueue_style( 
                    $style['name'],
                    $style['path'],
                    [],
                    $style['version']
                );
            }
        }

        if ($this->scripts){
            foreach ($this->scripts as $key => $script){
                wp_enqueue_script( 
                    $script['name'],
                    $script['path'],
                    ['jquery'],
                    $script['version'],
                    true
                );
            }
        }
    }

    /** 
     * Add enqueued
     * 
     * @since 1.0
     * @return void
     */
    public function add(array $data){

        $validate = $this->validate($data);

        if ( $validate !== true ){
            trigger_error("Array not valid", E_USER_ERROR);
            return $validate;
        }

        if ( strpos($data['path'], '.css') == true ){
            $this->styles[] = $data;
        }else if ( strpos($data['path'], '.js')  == true ){
            $this->scripts[] = $data;
        }

    }

    /**
     * Validate array by model
     * 
     * @param array $input
     * @return boolean|array
     */
    private function validate(array $input){

        $errors = [];

        $model = new Assert\Collection([
            'name'      => new Assert\Length(['min' => 3]),
            'path'      => new Assert\Length(['min' => 5]),
            'version'   => new NotBlank(),
        ]);
          
        $validator  = Validation::createValidator();
        $violations = $validator->validate($input, $model);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'property'      => $violation->getPropertyPath(),
                    'message'       => $violation->getMessageTemplate(),
                    'parameters'    => $violation->getParameters()
                ];
            }
            return $errors;
        }

        return true;   
    }
    
}