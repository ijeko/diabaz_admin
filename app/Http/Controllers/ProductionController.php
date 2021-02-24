<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ProductService;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function __construct () {
        $this->products = new ProductService();
        $this->materials = new MaterialService();
    }
    public function index()
    {

        return  $this->products->get()->toJson();;
    }

    public function ShowNorm(Request $request)
    {
       return response($this->products->GetProductionNorm($request->prodID));

    }

}
