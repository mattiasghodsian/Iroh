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

class Widget extends \WP_Widget
{
    /**
     * @var array $handler
     */
    private $handler;

    public function __construct(
        $id_base, $name,
        $widget_option = [], $control_option = []
    ) {
        parent::__construct(
            $id_base, $name,
            $widget_option, $control_option
        );

        $this->handler = new Handler;

        add_action('widgets_init', [$this, 'register']);
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

        // Used for creating admin panel layouts of widget
    }

    public function widget($args, $instance)
    {

        // Used to create front-end layout settings of widget
    }

    public function update($new_instance, $old_instance)
    {

        // updates the widget instance
    }

}
