<?php


namespace App\Http\Controllers;


use App\Factories\Factory;
use App\Factories\ModelFactory;
use App\Factories\ProductFactory;
use App\Http\Sevices\ProductService;
use App\Models\Materialnorm;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    private $productService;
    /**
     * @var ProductFactory
     */
    private $productFactory;
    private $product;

    public function __construct(ProductService $productService, Product $product, ProductFactory $productFactory)
    {
        $this->productService = $productService;
        $this->product = $product;
        $this->productFactory = $productFactory;
    }

    public function GetAllProductsMonthlyProduced(Request $request)
    {
        return json_encode($this->productService->Get($request->date));
    }

    public function GetMaterialsNormsForProduct(Request $request)
    {

        return response($this->productService
            ->GetMaterialsNormsOf($this->product->find($request->prodID)));
    }

    public function EditNorm(Request $request)
    {
$config = json_decode($request->data);
        $Factory = new ModelFactory();
        $model = $Factory->makeAnyModel('MaterialNorm', $config);
//dd($model->get());
        return $this->productService->EditMaterialsNormFor($model);
    }

    public function Edit(Request $request)
    {
        return $this->productService->EditProduct(json_decode($request->data));
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
        return $this->productService->newProduct(json_decode($request->data, 1));
    }

    public function GetSoldOnDate(Request $request)
    {
        {
            $data = $request;
            return $this->productService->getSold($data);

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
        return $this->productService->Stock();
    }

    public function Operations(Request $request)
    {
        $time = strtotime($request->date);
        $month = date('m', $time);
        $year = date('Y', $time);
        $process = $request->process;
        return $this->productService->GetPerMonth($year, $month, $process, $request->product);
    }

}
