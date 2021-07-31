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

use Helper\ErrorHandler;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\NotBlank;

class Enqueue {
    
    protected $scripts = [];
    protected $styles = [];
    protected $rewrite = [];
    public $errorHandler;

    /**
     * Construct
     * 
     * @return void
     */
    public function __construct(){

        $this->errorHandler = new ErrorHandler;

        add_action( 'wp_enqueue_scripts', [$this, 'enqueue'], 20 );   
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue'], 20, true );   

        add_filter( 'script_loader_src', [$this, 'rewrite'], 10, 2 ); 
        add_filter( 'style_loader_src', [$this, 'rewrite'], 10, 2 , true); 
    }

    /** 
     * Rewrite source with preg_replace
     * 
     * @param string $src
     * @param string $handle
     * @param bool $style default false
     * @return string
     */
    public function rewrite( $src, $handle, bool $style = false ){
        
        if ( $this->rewrite ){
            foreach ($this->rewrite as $key => $s) {
                if ( $handle == $s['slug'] && $s['style'] == $style){
                    $src = preg_replace($s['pattern'], $s['replacement'], $src);
                }
            }
        }
        
        return $src;
    }

    /** 
     * add source rewrite
     * 
     * @param array $rewrite
     * @return array
     */
    public function add_rewrite($rewrite){

        $errors = [];

        $model = new Assert\Collection([
            'slug'          => new Assert\Length(['min' => 3]),
            'pattern'       => new Assert\Type('string'),
            'replacement'   => new NotBlank(),
            'style'         => new Assert\Type('bool'),
        ]);

        $validator  = Validation::createValidator();
        $violations = $validator->validate($rewrite, $model);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'property'      => $violation->getPropertyPath(),
                    'message'       => $violation->getMessageTemplate(),
                    'parameters'    => $violation->getParameters()
                ];
            }
            $this->errorHandler->dump($errors);
        }else{
            $this->rewrite[] = $rewrite;
        }

    }

    /** 
     * Enqueued scripts
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
            $this->errorHandler->dump(['Array not valid']);
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
            $this->errorHandler->dump($errors);
        }

        return true;

    }
    
}