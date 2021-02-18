<?php


namespace App\Http\Sevices;


use App\Models\Product;

class ProductService
{
    private $product;
    public function __construct() {
        $this->product=new Product();
    }

    public function get() {
        return $this->product->get();
    }

}
