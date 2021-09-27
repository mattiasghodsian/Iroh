<?php

/**
 * This Helper class simplifys adding Widgets
 *
 * @package Iroh_Widget
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

use Helper\Arr\Handler;
use Helper\ErrorHandler;

class Widget extends \WP_Widget
{
    /**
     * @var array $handler
     */
    private $handler;
    private $error;
    public $name;

    public function __construct(
        $id_base, $name,
        $widget_option = [], $control_option = []
    ) {
        parent::__construct(
            $id_base, $name,
            $widget_option, $control_option
        );

        $this->name    = $name;
        $this->handler = new Handler;
        $this->error   = new ErrorHandler;

        add_action('widgets_init', [$this, 'register']);
    }

    /**
     * actions
     *
     * @param array $args
     *
     * @return void
     */
    public function actions(array $args)
    {
        foreach ($args as $method => $arg) {
            if (!method_exists($this, strtolower($method))) {
                $this->error->dump([sprintf('Method %s does not exist', $method)]);
            }

            $output = $this->handler->data_get($arg, 'output');

            $this->add_action($output, $method);

        }
    }

    public function add_action($output, $method)
    {
        add_action(
            'iroh_widget_' . strtolower($method) . '_' . $this->name,
            function ($instance) use ($output) {
                //Admin render here
            }
        );
    }

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        register_widget($this);
    }

    public function form($instance)
    {
        do_action('iroh_widget_form_' . $this->name, $instance);
    }

    public function widget($args, $instance)
    {

        // Used to create front-end layout settings of widget
    }

    public function update($new_instance, $old_instance)
    {

    }

}
