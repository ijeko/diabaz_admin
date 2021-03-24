<?php


namespace App\Factories;


class MaterialFactory extends Factory
{
    public function make($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }
}
