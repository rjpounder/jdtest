<?php

if (!function_exists('dd')) {
    /**
     * Dump & Die function
     * @param ...$args
     */
    function dd(...$args)
    {
        foreach ($args as $arg) {
            var_dump($arg);
        }

        exit();
    }
}
if (!function_exists('logger')) {
    /**
     * Log Data to a file or something
     *
     * @param ...$args
     */
    function logger(...$args)
    {
        //Not implemented
    }
}