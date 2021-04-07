<?php


namespace App\Http\Sevices;


use App\Models\Produced;
use App\Models\Product;
use App\Models\Sold;
use Illuminate\Database\Eloquent\Model;

class CheckerService extends Service
{
    public static function CheckMaterials(Produced $produced)
    {
        $product = $produced->product()->first();
        $norms = $product->materialNorm()->get();
        $materials = collect(MaterialService::GetMaterialQty());
        $materialsNotEnough = [];
        foreach ($norms as $checking) {
            if ($checking->norma * $produced->qty > $materials->firstWhere('id', $checking->material_id)['stock']) {

                array_push($materialsNotEnough, [
                    'material_id' => $checking->material_id,
                    'title' => $materials->firstWhere('id', $checking->material_id)['title'],
                    'qty' => ($materials->firstWhere('id', $checking->material_id)['stock'] - $checking->norma * $produced->qty) * -1
                ]);
            }
        }
        if (count($materialsNotEnough)) {
            return $materialsNotEnough;
        }
        else return false;

    }

    public static function CheckProductionStock(Sold $sold, Model $model)
    {
        if ($sold->qty >= $model->inStock()) return false;
        else return true;
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
