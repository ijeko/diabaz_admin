<?php


namespace App\Factories;


class ProducedFactory extends Factory
{
    public function makeProduction($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }
}
