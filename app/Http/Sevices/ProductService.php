<?php


namespace App\Http\Sevices;


use App\Factories\MaterialFactory;
use App\Factories\ModelFactory;
use App\Factories\ProductFactory;
use App\Models\Material;
use App\Models\Materialnorm;
use App\Models\Product;
use App\Models\Spoiled;

class ProductService extends Service
{

    public function GetProductsProducedAndSold($date): array
    {
        $target = $this->ParseDateBy($date);

        $products = [];

        foreach (Product::all() as $product) {
            array_push($products, [
                'id' => $product->id,
                'title' => $product->title,
                'name' => $product->name,
                'totalProduced' => $product->getProducedQty(),
                'monthProduced' => $product->produced()
                    ->whereYear('date', $target['year'])
                    ->whereMonth('date', $target['month'])
                    ->sum('qty'),
                'monthSold' => $product->getSoldQtyMonthly($target['month']),
                'totalSold' => $product->getSoldQty(),
                'stock' => round($product->inStock() - $this->ProductUsedAsMaterialQty($product->id), 2),
                'unit' => $product->unit
            ]);
        }
        return $products;
    }

    public function AddNewProductWith($attributes)
    {
        $Factory = new ProductFactory();
        $product = $Factory->make(Product::class, $attributes);

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
        $materialsForProduct = array();
        $usedMaterialsNorms = $product->materialNorm()->get();
        foreach ($usedMaterialsNorms as $usedMaterialNorma) {
            $id = $usedMaterialNorma->id;
            $title = $usedMaterialNorma->title;
            $norma = $usedMaterialNorma->norma;
            $unit = $usedMaterialNorma->material()->first()->unit;
            array_push($materialsForProduct, [
                'id' => $id,
                'title' => $title,
                'norma' => $norma,
                'material_id' => $usedMaterialNorma->material_id,
                'product_id' => $usedMaterialNorma->product_id,
                'unit' => $unit,
            ]);
        }
        return json_encode($materialsForProduct);
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
        }
        else
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
