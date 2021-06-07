<?php


namespace App\Http\Controllers;


use App\Builders\MaterialBuilder;
use App\Http\Services\MaterialService;
use App\Models\Material;
use App\Models\MaterialIncome;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{

    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function GetMaterials()
    {
        return json_encode($this->materialService->GetMaterialsWithQty());
    }

    public function AddNewMaterial(Request $request)
    {
        $attributes = json_decode($request->data, 1);
        return $this->materialService->AddNewMaterialWith($attributes);
    }

    public function EditMaterial(Request $request)
    {
        $newAttributes = json_decode($request->data, 1);
        return $this->materialService->SaveMaterialWith($newAttributes);
    }

    public function RemoveMaterial(Request $request)
    {
        Material::destroy($request->id);
    }

    public function GetMonthlyMaterialIncome()
    {

        return $this->materialService->GetMonthlyMaterialIncome();
    }

    public function AddNewMaterialIncome(Request $request)
    {
        $newIncome = json_decode($request->data, 1);
        MaterialIncome::create($newIncome);
    }

    public function RemoveIncome(Request $request)
    {
        MaterialIncome::destroy($request->id);
    }
}
