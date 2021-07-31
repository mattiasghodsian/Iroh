<?php

/**
 * Helper for dumping error messages
 *
 * @package Iroh_ErrorHandler
 * @author Mattias Ghodsian
 * @source https://github.com/mattiasghodsian/Iroh
 * @license GPL 2.0
 */

namespace Helper;

class ErrorHandler
{
    private $msg;

    public function __construct()
    {
        $this->msg = 'An error has occurred';
    }

    /**
     * Dump and die
     *
     * @param array $errors
     */
    public function dump(array $errors)
    {
        dump($this->msg, $errors);
        die();
    }
}
