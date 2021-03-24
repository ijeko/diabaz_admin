<?php


namespace App\Factories;


class ProductFactory extends Factory
{
    public function make($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }
}
