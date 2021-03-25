<?php


namespace App\Factories;


abstract class Factory
{
    function __construct($namespace = 'App\\Models')
    {
        $this->namespace = $namespace;
    }

    public function makeAnyModel($source, $config = [])
    {
        $name = $this->namespace . '\\' . $source;

        if (class_exists($name)) {
            return new $name($config);
        }
    }

    public function make($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }

    public function Update ($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }
}
