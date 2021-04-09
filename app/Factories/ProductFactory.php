<?php


namespace App\Factories;


use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * @var Product
     */

    public function __construct($namespace = 'App\\Models')
    {
        parent::__construct($namespace);
    }

    public static function build($config = []): Product
    {
        return new Product($config);
    }

    public function make($source, $config = [])
    {
        if (class_exists($source)) {
            return new $source($config);
        }
    }
}
