<?php

if (!function_exists('app')) {
    function app($package = null)
    {
        $container =  \Illuminate\Container\Container::getInstance();
        return ($package) ? $container->get($package) : $container;
    }
}

if (!function_exists('config')) {
    function config($var = null)
    {
        $config = app()->get('config');
        return ($var) ? $config->get($var) : $config;
    }
}

if (!function_exists('logger')) {
    function logger()
    {
        return app()->get('logger');
    }
}

if (!function_exists('loadEnvironmentFromFile')) {
    function loadEnvironmentFromFile($file)
    {
        $dotEnv = \Dotenv\Dotenv::create(dirname($file), basename($file));
        return $dotEnv->overload();
    }
}
