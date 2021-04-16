<?php


namespace App\Http\Sevices;


use App\Builders\MaterialBuilder;
use App\Factories\MaterialFactory;

use App\Models\Material;
use App\Models\MaterialIncome;

class MaterialService extends Service
{

    public function __construct()
    {
        $this->material = new Material();
        $this->income = new MaterialIncome();
    }

    public function GetMonthlyMaterialIncome()
    {
        $builder = new MaterialBuilder();
        $monthlyMaterialIncomes = collect();
        foreach (Material::all() as $material) {
            $builder->InitiateExisting($material);
            $builder->BuildMonthlyIn();
            $monthlyMaterialIncomes->push($builder->GetProduct());
        }
        return $monthlyMaterialIncomes;
    }

    public static function GetMaterialsWithQty()
    {
        $materialQty = [];
        foreach (Material::all() as $material) {
            array_push($materialQty, [
                'id' => $material->id,
                'title' => $material->title,
                'name' => $material->name,
                'income' => round($material->getIncomeSumm(), 2),
                'used' => $material->used(),
                'stock' => round($material->inStock(), 2),
                'unit' => $material->unit,
                'minQty' => $material->minQty
            ]);
        }
        return $materialQty;
    }

    public function IncomesPerMonthOf($material, $date)
    {
        return false;
    }

    public function SaveMaterialWith($newAttributes)
    {
        Material::where('name', $newAttributes['name'])->update($newAttributes);
        return \response('Информация о материале изменена', '200');
    }

    public function AddNewMaterialWith($attributes)
    {
        $builder = new MaterialBuilder();
        $material = $builder->GetProduct();
        $material->fill($attributes);
        if (CheckerService::IsNewAdminItemExits($material)) {
            return \response(['error' => 'Запись уже существует'], '403');
        } else $material->save();
        return \response('Запись добавлена', '200');
    }
}
