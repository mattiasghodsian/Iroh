<?php

/**
 * Helper class for object and arrays
 *
 * @package Iroh_Helper_Arr
 * @author Laravel
 * @source https://github.com/laravel/laravel
 * @license GPL 2.0
 */

namespace Helper\Arr;

class Handler
{

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }

    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed $target
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }
        foreach (explode('.', $key) as $segment) {
            if (is_array($target)) {
                if (!array_key_exists($segment, $target)) {
                    return $this->value($default);
                }
                $target = $target[$segment];
            } elseif ($target instanceof \ArrayAccess) {
                if (!isset($target[$segment])) {
                    return $this->value($default);
                }
                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (!isset($target->{$segment})) {
                    return $this->value($default);
                }
                $target = $target->{$segment};
            } else {
                return $this->value($default);
            }
        }
        return $target;
    }

}
