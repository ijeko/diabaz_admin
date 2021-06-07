<?php


namespace App\Http\Services;


use App\Builders\BuilderManager;
use App\Builders\ProductBuilder;
use App\Exceptions\OutOfStockException;
use App\Factories\MaterialFactory;
use App\Factories\ModelFactory;
use App\Factories\ProductFactory;
use App\Models\Material;
use App\Models\Materialnorm;
use App\Models\Product;
use App\Models\Spoiled;

class ProductService extends Service
{

    public function CreateProductsForDashboard()
    {
        $manager = new BuilderManager();
        $builder = new ProductBuilder();
        $manager->SetBuilder($builder);
        $result = collect();
        foreach (Product::all() as $product) {
            $manager->MakeProductsForDashboard($product);
            $result->push($builder->GetProduct());
        }
        return $result;
    }

    public function AddNewProductWith($attributes)
    {
        $builder = new ProductBuilder();
        $product = $builder->GetProduct();
        $product->fill($attributes);

        if (CheckerService::IsNewAdminItemExits($product)) {
            return \response(['error' => 'Запись уже существует'], '403');
        } else {
            $product->save();
            return \response('Запись добавлена', '200');
        }
    }


    public function SaveProductWith($newAttributes)
    {
        return Product::where('name', $newAttributes['name'])->update($newAttributes);
    }

    public function GetMaterialsNormsOf(Product $product)
    {
        $builder = new ProductBuilder();
        $builder->InitiateExisting($product);
        $builder->BuildProductWithMaterialNorms();
        return $builder->GetProduct();
    }


    public function EditMaterialsNormWith($newNorms)
    {
        foreach ($newNorms as $normData) {
            Materialnorm::updateOrCreate(
                [
                    'product_id' => $normData['product_id'],
                    'material_id' => $normData['material_id']
                ],
                $normData);
        }
        return \response('New data saved', '200');
    }

    public function AddSpoiled($attributes)
    {
        $spoiled = new Spoiled();
        $spoiled->fill($attributes);

        $builder = new ProductBuilder();
        $builder->InitiateExisting(Product::find($attributes['product_id']));
        $builder->BuildStock();
        $production = $builder->GetProduct();
        if (CheckerService::CheckProductionStock($spoiled, $production)) {
            $spoiled->save();
        } else
        {
            $errorData = json_encode(['error' => 'Не хватает: ' . $production->title]);
            Throw new OutOfStockException($errorData);
        }
    }

    public function GetProducedSoldSpoiled($product)
    {

        $builder = new ProductBuilder();
        $manager = new BuilderManager();
        $manager->SetBuilder($builder);
        $manager->MakeProductForAdminDashboard(Product::find($product));
        return $builder->GetProduct();
    }
}
