<?php


namespace App\Http\Sevices;


use App\Builders\BuilderManager;
use App\Builders\ProductBuilder;
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
        $Factory = new ModelFactory();
        $spoiled = $Factory->make(Spoiled::class, $attributes);
        if (CheckerService::CheckProductionStock($spoiled)) {
            $spoiled->save();
        } else
            return \response(['error' => 'Не хватает: ' . $spoiled->title]);
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
