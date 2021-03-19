<?php


namespace App\Http\Sevices;


class ModelFactory
{
    function __construct($namespace = 'App\\Models')
    {
        $this->namespace = $namespace;
    }

    public function makeModel($source, $config = [])
    {
        $name = $this->namespace . '\\' . $source;

        if (class_exists($name)) {
            return new $name($config);
        }
    }

    public function makeRelationModel($source, $relation)
    {
        $name = $this->namespace . '\\' . $source;

        if (class_exists($name)) {
            return new $source->$relation();
        }
    }
}
