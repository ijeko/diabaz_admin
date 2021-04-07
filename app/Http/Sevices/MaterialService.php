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

    public function getInfo($id, $param)
    {
        $test = $this->material->find($id)->$param;
        return $test;
    }

    public function get()
    {
        return $this->material->All();
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

    public static function GetMaterialQty()
    {
        $materials = new Material();
        $sold = new Sold();
        $materials = $materials->get();
        $materialQty = [];
        foreach ($materials as $material) {
            $used = 0;
            $sold = $material->getSoldQty();
            foreach ($material->norma() as $norma) {
                $used = $used + $norma->product()->find($norma->product_id)->getProducedQty() * $norma->norma;
            }
            array_push($materialQty, [
                'id' => $material->id,
                'title' => $material->title,
                'name' => $material->name,
                'income' => round($material->getIncomeSumm(), 2),
                'used' => $used,
                'stock' => round($material->getIncomeSumm() - $used - $sold, 2),
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
        $check = CheckerService::CheckExists($model);
        if ($check) return $check;
        else $model->save();
        return Response::HTTP_OK;
    }
}
