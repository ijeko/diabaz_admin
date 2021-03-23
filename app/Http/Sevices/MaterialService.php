<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\MaterialIncome;
use App\Models\MaterialMinimum;
use App\Models\Product;
use Illuminate\Http\Response;

class MaterialService
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

    public function GetMaterialQty()
    {
        $materials = $this->material->get();
        $materialQty = [];
        foreach ($materials as $material) {
            $used = 0;
            foreach ($material->norma() as $norma) {
                $used = $used + $norma->product()->find($norma->product_id)->getProducedQty() * $norma->norma;
            }
            array_push($materialQty, [
                'id' => $material->id,
                'title' => $material->title,
                'income' => $material->getIncomeSumm(),
                'used' => $used,
                'stock' => $material->getIncomeSumm() - $used,
                'unit' => $material->unit,
                'minQty' => $material->minQty
            ]);
        }
        $response = $materialQty;
        return json_encode($response);
    }

    public function EditMaterial($data)
    {
        $records = $this->material->find($data->id);

        $records->update(['title' => $data->title, 'name' => $data->name, 'unit' => $data->unit, 'minQty' => $data->minQty]);
    }

    public function newMaterial($data)
    {
        if ($this->material->where('title', $data->title)->exists()) {
            return response()->
            json([
                'name' => '',
                'title' => 'Значение уже используется'
            ]);
        }
        if ($this->material->where('name', $data->name)->exists()) {
            return response()->
            json([
                'name' => 'Значение уже используется',
                'title' => ''
            ]);
        } else {
            $config = [
                'title' => $data->title,
                'name' => $data->name,
                'unit' => $data->unit,
                'minQty' => $data->minQty
            ];
            $Factory = new ModelFactory();
            $material = $Factory->makeModel('Material', $config);
            $material->save();
            return Response::HTTP_OK;
        }
    }

    public function chekInStock($toCheck, $data)
    {
        $materials = collect(json_decode($this->GetMaterialQty()));
        $materialsNotEnough = [];
        foreach ($toCheck as $norma) {
            $checkedMaterial = $materials->where('id', $norma->material_id)->first();
            $needed = $data->qty * $norma->norma;
            if ($checkedMaterial->stock <= $needed) {
                array_push($materialsNotEnough, [
                    'material_id' => $norma->material_id,
                    'title' => $checkedMaterial->title,
                    'qty' => ($checkedMaterial->stock - $needed) * -1
                ]);
            }
        }
        return $materialsNotEnough;
    }
}
