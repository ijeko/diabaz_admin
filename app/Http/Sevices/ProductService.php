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


//        $materialsForProduct = array();
//        $usedMaterialsNorms = $product->materialNorm()->get();
//        foreach ($usedMaterialsNorms as $usedMaterialNorma) {
//            $id = $usedMaterialNorma->id;
//            $title = $usedMaterialNorma->title;
//            $norma = $usedMaterialNorma->norma;
//            $unit = $usedMaterialNorma->material()->first()->unit;
//            array_push($materialsForProduct, [
//                'id' => $id,
//                'title' => $title,
//                'norma' => $norma,
//                'material_id' => $usedMaterialNorma->material_id,
//                'product_id' => $usedMaterialNorma->product_id,
//                'unit' => $unit,
//            ]);
//        }
//        return json_encode($materialsForProduct);
    }


    public function EditMaterialsNormWith($newNorms)
    {
        foreach ($newNorms as $normData) {
            $norm = Materialnorm::firstOrCreate([
                'product_id' => $normData['product_id'],
                'material_id' => $normData['material_id']
            ], $normData);
            $norm->update($normData);
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

    public function GetSpoiledPerMonth($date, $id)
    {
        $Factory = new MaterialFactory();
        $spoiledItems = $Factory->make(Spoiled::class);
        $target = $this->ParseDateBy($date);
        return $spoiledItems
            ->whereYear('date', $target['year'])
            ->whereMonth('date', $target['month'])
            ->where('product_id', $id)
            ->get();
    }

//TODO Удалить если метод не используется

//    public function getSold($data)
//    {
//        $today = $data->date;
//
//        foreach ($this->product->all() as $product) {
//            $productSold = $this->sold->where('date', $today)->where('product_id', $product->id)->get()->sum('qty');
//            $sold[] = ['product_id' => $product->id, 'qty' => $productSold];
//        }
//
//        return response()->
//        json($sold);
//    }

    public function ProductUsedAsMaterialQty($id): int
    {
        $asMaterial = 0;
        foreach (Material::all() as $material) {
            if (Product::find($id)->name === $material->name) {
                $asMaterial = $material->getIncomeSumm();
            }
        }
        return $asMaterial;
    }
}
