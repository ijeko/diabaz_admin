<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\MaterialIncome;
use App\Models\Materialnorm;

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

    public function GetProductionNorm($prodID)
    {
        $matNorm = new Materialnorm();
        $matNorm->product()->get($prodID);
        dd($matNorm);
    }

    public function GetIncomesOnDate($date)
    {
//        dd(__METHOD__, $date);
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
        $totalIncomeQty = [];
        $totalUsedQty = [];

        foreach ($materials as $material) {
            $used = 0;
            foreach ($material->norma() as $norma) {
                $used = $used + $norma->product()->find($norma->product_id)->getProducedQty() * $norma->norma;
            }
//           echo $material->title.' Приехало: '.$material->getIncomeSumm().' потрачено: '.$used.'<br>';
            array_push($totalIncomeQty, [
                'material_id' => $material->id, 'qty' => $material->getIncomeSumm()
            ]);
            array_push($totalUsedQty, [
                'material_id' => $material->id, 'qty' => $used
            ]);
        }
        $response=['totalIncomes'=>$totalIncomeQty, 'totalUsed' => $totalUsedQty];
//        dd($response);
        return json_encode($response);
    }

}
