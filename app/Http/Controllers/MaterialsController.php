<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function __construct()
    {
        $this->materials = new MaterialService();
    }

    public function index()
    {
//dd(__METHOD__, $request->data);
        return $this->materials->get();
    }

    public function GetIncomes(Request $request)
    {
        return $this->materials->GetIncomesOnDate($request->date);
    }

    public function AddIncome(Request $request)
    {
        return $this->materials->SaveNewIncome(json_decode($request->data));
    }

    public function getQty()
    {
        return $this->materials->GetMaterialQty();
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

    public function Add(Request $request)
    {
        return $this->materials->newMaterial(json_decode($request->data));
    }

    public function Edit(Request $request)
    {
        return $this->materials->EditMaterial(json_decode($request->data));
    }


}
