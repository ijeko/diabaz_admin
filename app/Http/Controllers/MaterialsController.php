<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Models\Material;
use App\Models\MaterialIncome;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    private $material;
    private $materialService;
    public function __construct(Material $material, MaterialService $materialService)
    {
        $this->material = $material;
        $this->materialService = $materialService;
    }

    public function GetMaterials()
    {
        return json_encode($this->materialService->GetMaterialsWithQty());
    }

    public function GetMaterialsIncome(Request $request)
    {
        return $this->materialService->GetPerMonth($request->date);
    }

    public function AddIncome(Request $request)
    {
        return $this->materialService->SaveNewIncome(json_decode($request->data));
    }


    public function Remove(Request $request)
    {
        $model = new Material();
        $material = $model->find($request->id);
        if ($material) {
            $material->delete();
        }
        echo 'Nothing to delete';
    }

    public function RemoveIncome(Request $request)
    {
        $model = new MaterialIncome();
        $income = $model->find($request->id);
        if ($income) {
            $income->delete();
        }
        echo 'Nothing to delete';
    }

    public function Add(Request $request)
    {
        return $this->materialService->newMaterial(json_decode($request->data, 1));
    }

    public function Edit(Request $request)
    {
        return $this->materialService->EditMaterial(json_decode($request->data, 1));
    }


}
