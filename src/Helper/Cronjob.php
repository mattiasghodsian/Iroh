<?php

/**
 * This Helper class simplifys adding cronjob tasks
 * 
 * @package Iroh_Cronjob
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\NotBlank;

class Cronjob {

    private $recurrences = [];
    private $events = [];

    /**
     * construct
     * 
     * @return void
     */
    public function __construct(){

        add_filter( 'cron_schedules', function($schedules){
            if ( $this->recurrences ){
                $schedules = array_merge($schedules, $this->recurrences);
            }
            return $schedules;
        });

		add_action('init', [ $this, 'schedule_events'], 10);
    }

    /**
	 * Schedule event 
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function schedule_events() {

        if ( $this->events ){
            foreach ($this->events as $key => $event) {
                if ( !wp_next_scheduled( $event['hook'], $event['args'] ) ){
                    wp_schedule_event( 
                        $event['timestamp'],
                        $event['recurrence'],
                        $event['hook'],
                        $event['args'],
                        $event['wp_error'] 
                    );
                }
            }
        }

	}

    /**
	 * Add cron event 
	 *
     * @param array $event
	 * @return array
	 */
    public function add_event($event){

        $errors = [];

        $model = new Assert\Collection([
            'hook'          => new NotBlank(),
            'args'          => new Assert\Type('array'),
            'timestamp'     =>new Assert\Type('integer'),
            'recurrence'    => new NotBlank(),
            'wp_error'      => new Assert\Type('bool'),
        ]);

        $validator  = Validation::createValidator();
        $violations = $validator->validate($event, $model);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'property'      => $violation->getPropertyPath(),
                    'message'       => $violation->getMessageTemplate(),
                    'parameters'    => $violation->getParameters()
                ];
            }
            return $errors;
        }else{
            $this->events[] = $event;
        }

    }
		
    /**
	 * Add recurrence schedule
	 *
	 * @param array $schedule
	 * @return array
	 */
    public function add_recurrence( $recurrence ){

        $errors = [];

        $model = new Assert\Collection([
            'key'       => new Assert\Length(['min' => 10]),
            'interval'  => new Assert\Positive(),
            'display'   => new NotBlank(),
        ]);

        $validator  = Validation::createValidator();
        $violations = $validator->validate($recurrence, $model);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'property'      => $violation->getPropertyPath(),
                    'message'       => $violation->getMessageTemplate(),
                    'parameters'    => $violation->getParameters()
                ];
            }
            return $errors;
        }else{
            $this->recurrences[ $recurrence['key'] ] = [
                'interval'  => $recurrence['interval'],
                'display'   => $recurrence['display']
            ];
        }
        
    }

    /**
	 * Retrive registry of set tasks and recurrence schedules
	 *
	 * @return array
	 */
    public function registry(){
        $data = [
            'events'        => _get_cron_array(),
            'recurrences'   => wp_get_schedules()
        ];

        return $data;
    }

}