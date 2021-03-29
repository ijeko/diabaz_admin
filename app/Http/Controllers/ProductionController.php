<?php


namespace App\Http\Controllers;


use App\Factories\ProductFactory;
use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ModelFactory;
use App\Http\Sevices\ProductService;
use App\Models\Materialnorm;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function __construct()
    {
        $this->products = new ProductService();
        $this->materials = new MaterialService();
    }

    public function index(Request $request)
    {

        return json_encode($this->products->get($request->date));
    }

    public function ShowNorm(Request $request)
    {
        return response($this->products->GetProductionNorm($request->prodID));

    }

    public function EditNorm(Request $request)
    {
        return $this->products->EditProductionNorm(json_decode($request->data));
    }

    public function Edit(Request $request)
    {
        return $this->products->EditProduct(json_decode($request->data));
    }

    public function RemoveNorm(Request $request)
    {
        $model = new Materialnorm();
        $norm = $model->find($request->id);
        if ($norm) {
            $norm->delete();
        }
        echo 'Nothing to delete';
    }

    public function Remove(Request $request)
    {
        $Factory = new ProductFactory();
        $model = $Factory->makeAnyModel($request->model);
        $model = $model->find($request->id);
        if ($model) {
            $model->delete();
        }
        echo 'Nothing to delete';
    }

    public function Add(Request $request)
    {
        return $this->products->newProduct(json_decode($request->data, 1));
    }

    public function GetSoldOnDate(Request $request)
    {
        {
            $data = $request;
            return $this->products->getSold($data);

        }
    }

//    public function AddSold(Request $request)
//    {
//
//        $data = json_decode($request->data, 1);
//        return $this->products->AddSold($data);
//    }

    public function GetStockByProduct(Request $request)
    {
        return $this->products->Stock();
    }
    public function Operations(Request $request) {
        $time = strtotime($request->date);
        $month = date('m', $time);
        $year = date('Y', $time);
        $process = $request->process;
        return $this->products->GetPerMonth($year, $month, $process, $request->product);
    }

}
