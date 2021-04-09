<?php

namespace App\Http\Controllers;

use App\Factories\ModelFactory;
use App\Http\Sevices\SoldService;
use App\Models\Sold;
use Illuminate\Http\Request;

class SoldController extends Controller
{
    private $sold;
    private $soldService;
    public function __construct(SoldService $soldService, Sold $sold)
    {
       $this->soldService = $soldService;
       $this->sold = $sold;
    }

    //
    public function AddSold(Request $request)
    {
        $data = json_decode($request->data, 1);
        $Factory = new ModelFactory();
        $model = $Factory->makeAnyModel(ucfirst($data['model']));
        return $this->soldService->AddSold($model->find($data['product_id']), $data);
    }

    public function GetAdminSoldItems (Request $request)
    {
        $date = $request->date;
        $product_id = $request->product;
        return $this->soldService->GetPerMonth($date, $product_id);
    }
}
