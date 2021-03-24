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
}
