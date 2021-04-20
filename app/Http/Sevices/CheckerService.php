<?php


namespace App\Http\Sevices;


use App\Builders\MaterialBuilder;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CheckerService extends Service
{
    public static function CheckMaterialsForProduction(Product $product, $qty)
    {
        $materialBuilder = new MaterialBuilder();
        $materialsNotEnough = [];
        foreach ($product->materialsNorms as $checking) {
            $materialBuilder->InitiateExisting(Material::find($checking['material_id']));
            $materialBuilder->BuildStock();
            $material=$materialBuilder->GetProduct();
            $materialNeed = $checking['norma'] * $qty;
            if ( $materialNeed > $material->stock) {
                array_push($materialsNotEnough, [
                    'material_id' => $checking['material_id'],
                    'title' => $material->title,
                    'qty' => $materialNeed - $material->stock,
                    'unit' => $material->unit
                ]);
            }
        }
        if (count($materialsNotEnough)) {
            return $materialsNotEnough;
        }
        else return false;

    }

    public static function CheckProductionStock(Model $toCheck, Model $production)
    {
        if ($toCheck->qty > $production->stock)
            return false;
        else
            return true;
    }

    public static function IsNewAdminItemExits($model)
    {
        if ($model->whereTitle($model->title)->exists()) {
            return response()->
            json([
                'name' => '',
                'title' => 'Значение уже используется'
            ]);
        }
        if ($model->whereName($model->name)->exists()) {
            return response()->
            json([
                'name' => 'Значение уже используется',
                'title' => ''
            ]);
        }
        else return false;
    }
}
