<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ProductService;
use App\Models\Materialnorm;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function __construct()
    {
        $this->products = new ProductService();
        $this->materials = new MaterialService();
    }

    public function index()
    {

        return $this->products->get()->toJson();;
    }

    public function ShowNorm(Request $request)
    {
        return response($this->products->GetProductionNorm($request->prodID));

    }

    public function EditNorm(Request $request)
    {
        $this->products->EditProductionNorm(json_decode($request->data));
    }

    public function RemoveNorm(Request $request)
    {
        $norm = new Materialnorm();
        $norm->find($request->id)->remove();
    }

}
