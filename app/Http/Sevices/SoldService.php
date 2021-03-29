<?php


namespace App\Http\Sevices;


use App\Factories\SoldFactory;
use App\Models\Sold;
use Illuminate\Database\Eloquent\Model;

class SoldService
{

    public function AddSold(Model $model, $data)
    {
        $Factory = new SoldFactory();
        $sold = $Factory->make(Sold::class, $data);
        $sold->isMaterial = $model->isMaterial;
        if (CheckerService::CheckProductionStock($sold, $model)) $sold->save();
        else   return \response(['error' => 'Не хватает: ' . $model->title]);
    }
}
