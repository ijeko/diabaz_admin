<?php


namespace App\Http\Controllers;


use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ProductService;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function __construct () {
        $this->materials = new MaterialService();
    }
    public function index()
    {
//dd(__METHOD__, $request->data);
        return  $this->materials->get();
    }

    public function GetIncomes (Request $request) {
        return $this->materials->GetIncomesOnDate($request->date);
    }
    public function AddIncome (Request $request)
    {
        return $this->materials->SaveNewIncome(json_decode($request->data));
    }
    public  function getQty () {
        return $this->materials->GetMaterialQty();
    }

}
