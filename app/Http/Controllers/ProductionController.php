<?php


namespace App\Http\Controllers;


use App\Http\Sevices\ProductService;

class ProductionController extends Controller
{
    public function __construct () {
        $this->products = new ProductService();
    }
    public function index()
    {

        return  $this->products->get()->toJson();;
    }

}
