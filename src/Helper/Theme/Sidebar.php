<?php

/**
 * This Helper class simplifys adding sidebars
 *
 * @package Iroh_Widget
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper\Theme;

use Helper\Arr\Handler;

class Sidebar
{
    /**
     * @var array $sidebar
     * @var Handler $handler
     */
    public $sidebars;
    public $handler;

    public function __construct()
    {
        $this->handler  = new Handler;
        $this->sidebars = [];

        add_action('widgets_init', [$this, 'register']);
    }

    /**
     * add
     * @param  array  $data
     *
     * @return this
     */
    public function add(array $data)
    {
        $this->sidebars[] = [
            'name'          => $this->handler->data_get($data, 'name'),
            'id'            => $this->handler->data_get($data, 'id'),
            'class'         => $this->handler->data_get($data, 'class'),
            'description'   => $this->handler->data_get($data, 'description'),
            'before_widget' => $this->handler->data_get($data, 'before_widget', '<div>'),
            'after_widget'  => $this->handler->data_get($data, 'after_widget', '</div>'),
            'before_title'  => $this->handler->data_get($data, 'before_title', '<h2>'),
            'after_title'   => $this->handler->data_get($data, 'before_title', '</h2>'),
        ];

        return $this;
    }

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        if (!empty($this->sidebars)) {
            foreach ($this->sidebars as $sidebar) {
                register_sidebar($sidebar);
            }
        }
    }

}
