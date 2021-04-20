<?php


namespace App\Http\Controllers;


use App\Factories\ProductFactory;
use App\Http\Sevices\ProducedService;
use App\Http\Sevices\ProductService;
use App\Http\Sevices\SoldService;
use App\Models\Materialnorm;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    private $productService;
    /**
     * @var ProductFactory
     */
    private $factory;
    private $product;
    private $soldService;
    private $procucedService;

    public function __construct(ProductService $productService,
                                Product $product,
                                ProductFactory $productFactory,
                                SoldService $soldService,
                                ProducedService $producedService)
    {
        $this->productService = $productService;
        $this->soldService = $soldService;
        $this->procucedService = $producedService;
        $this->product = $product;
        $this->factory = $productFactory;
    }

    public function GetProducts()
    {

        return $this->productService->CreateProductsForDashboard();
    }

    public function AddNewProduct(Request $request)
    {
        $attributes = json_decode($request->data, 1);
        return $this->productService->AddNewProductWith($attributes);
    }

    public function EditProduct(Request $request)
    {
        $newAttributes = json_decode($request->data, 1);
        return $this->productService->SaveProductWith($newAttributes);
    }

    public function Remove(Request $request)
    {
        $model = $request->model;
        $id = $request->id;
        return $this->productService->Remove($model, $id);
    }

    public function GetMaterialsNormsForProduct(Request $request)
    {

        return response($this->productService
            ->GetMaterialsNormsOf($this->product->find($request->prodID)));
    }

    public function EditMaterialNormsOfProduct(Request $request)
    {
        $newNorms = json_decode($request->data, 1);
        return $this->productService->EditMaterialsNormWith($newNorms);
    }

    public function DeleteNormFromProduction(Request $request)
    {
        Materialnorm::destroy($request->id);
    }

    public function AddSpoiledProduct(Request $request)
    {
        $product = json_decode($request->data, 1);;
        return $this->productService->AddSpoiled($product);
    }

    public function AddProduced(Request $request)
    {
        // TODO Исправить метод проверки количества материалов для работы с билдерами.
        $data = $request->data;
        return $this->procucedService->save($data);
    }

    public function AddSold(Request $request)
    {
        $production = json_decode($request->data, 1);
        return $this->soldService->AddSold($production);
    }

    public function GetProductForAdminDashboard(Request $request)
    {
        $product_id = $request->product;
        return $this->productService->GetProducedSoldSpoiled($product_id);
    }


}
