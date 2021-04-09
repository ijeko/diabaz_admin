<?php


namespace App\Http\Sevices;


use App\Factories\MaterialFactory;
use App\Factories\ModelFactory;
use App\Models\Material;
use App\Models\MaterialIncome;
use App\Models\MaterialMinimum;
use App\Models\Sold;
use Illuminate\Http\Response;

class MaterialService extends Service
{

    public function __construct()
    {
        $this->material = new Material();
        $this->income = new MaterialIncome();
    }

    public function GetPerMonth($date)
    {
        $target = $this->ParseDateBy($date);
        $monthlyMaterialIncomes = [];
        foreach (Material::all() as $material) {
            array_push($monthlyMaterialIncomes, [
                'id' => $material->id,
                'title' => $material->title,
                'qty' => $material->getMonthlyIncomeSumm($target['month']),
                'unit' => $material->unit
            ]);
        }
        dd($monthlyMaterialIncomes);
        return $monthlyMaterialIncomes;
    }

    public function GetIncomesOnDate($date)
    {
        return $this->income->where('date', $date)->get();
    }

    public function SaveNewIncome($data)
    {
        $this->income->material_id = $data->material_id;
        $this->income->date = $data->date;
        $this->income->qty = $data->qty;
        $this->income->user_id = $data->user_id;
        $this->income->save();
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

    public function EditMaterial($data)
    {
        $material = new Material();
        $material->find($data['id'])->update($data);
    }

    public function newMaterial($data)
    {
        $Factory = new MaterialFactory();
        $model = $Factory->make(Material::class, $data);
        if (CheckerService::IsNewAdminItemExits($model)) {
            return \response(['error' => 'Запись уже существует'], '403');
        } else $model->save();
        return \response('Запись добавлена', '200');
    }
}
