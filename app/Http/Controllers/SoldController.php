<?php

namespace App\Http\Controllers;

use App\Factories\ModelFactory;
use App\Http\Sevices\SoldService;
use Illuminate\Http\Request;

class SoldController extends Controller
{
    public function __construct()
    {
        $this->service = new SoldService();
    }

    //
    public function AddSold(Request $request)
    {
        $data = json_decode($request->data, 1);
        $Factory = new ModelFactory();
        $model = $Factory->makeAnyModel(ucfirst($data['model']));
        return $this->service->AddSold($model->find($data['product_id']), $data);

    }
}
