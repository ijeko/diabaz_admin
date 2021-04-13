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
    private $factory;
    private $product;

    public function __construct(ProductService $productService, Product $product, ProductFactory $productFactory)
    {
        $this->productService = $productService;
        $this->product = $product;
        $this->factory = $productFactory;
    }

    public function GetProducts(Request $request): array
    {

        return $this->productService->GetProductsProducedAndSold($request->date);
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

    public function GetAdminSpoiledItems (Request $request)
    {
        $date = $request->date;
        $product_id = $request->product;
        return $this->productService->GetSpoiledPerMonth($date, $product_id);
    }
}
