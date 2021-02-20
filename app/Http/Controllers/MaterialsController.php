<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ProductService;

class MaterialsController extends Controller
{
    public function __construct () {
        $this->materials = new MaterialService();
    }
    public function index()
    {

        return  $this->materials->get()->toJson();;
    }

}
