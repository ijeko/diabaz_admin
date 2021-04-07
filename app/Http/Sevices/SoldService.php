<?php


namespace App\Http\Sevices;


use App\Factories\SoldFactory;
use App\Models\Sold;
use Illuminate\Database\Eloquent\Model;

class SoldService extends Service
{

    public function AddSold(Model $model, $data)
    {
        $Factory = new SoldFactory();
        $sold = $Factory->make(Sold::class, $data);
        $sold->isMaterial = $model->isMaterial;
        if (CheckerService::CheckProductionStock($sold, $model)) $sold->save();
        else   return \response(['error' => 'Не хватает: ' . $model->title]);
    }

    public function GetPerMonth($date, $id)
    {
        $Factory = new SoldFactory();
        $producedItems = $Factory->make(Sold::class);
        $target = $this->ParseDateBy($date);
        return $producedItems
            ->whereYear('date', $target['year'])
            ->whereMonth('date', $target['month'])
            ->where('product_id', $id)
            ->get();
    }
}
