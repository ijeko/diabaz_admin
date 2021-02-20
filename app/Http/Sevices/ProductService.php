<?php


namespace App\Http\Sevices;


use App\Models\Produced;
use App\Models\Product;

class ProductService
{
    private $product;
    public function __construct() {
        $this->product=new Product();
        $this->produced = new Produced();
    }

    public function get() {
        return $this->product->get();
    }

}
