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
     * Construct
     * 
     * @return void
     */
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue'], 20 );   
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue'], 20, true );   
    }

    /** 
     * Enqueued scripts.
     * 
     * @param bool $admin
     * @return void
     */
    public function enqueue(bool $admin = false){

        if ($this->styles){
            foreach ($this->styles as $key => $style){
                if( $style['admin'] === $admin ){
                    wp_enqueue_style( 
                        $style['name'],
                        $style['path'],
                        [],
                        $style['version']
                    );
                }
                
            }
        }

        if ($this->scripts){
            foreach ($this->scripts as $key => $script){
                if( $script['admin'] === $admin ){
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
    }

    /** 
     * Add enqueue
     * 
     * @param array $data
     * @param bool $admin
     * @return void
     */
    public function add(array $data, bool $admin = false){

        $validate = $this->validate($data);

        if ( $validate !== true ){
            trigger_error("Array not valid", E_USER_ERROR);
            return $validate;
        }

        $data['admin'] = $admin;

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