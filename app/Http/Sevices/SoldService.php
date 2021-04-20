<?php


namespace App\Http\Sevices;


use App\Builders\MaterialBuilder;
use App\Builders\ProductBuilder;
use App\Factories\SoldFactory;
use App\Models\Material;
use App\Models\Product;
use App\Models\Sold;

class SoldService extends Service
{
    public function AddSold($production)
    {
        if ($production['isMaterial']) {
            $builder = new MaterialBuilder();
            $object = Material::find($production['product_id']);
        } else {
            $builder = new ProductBuilder();
            $object = Product::find($production['product_id']);
        }

        $sold = new Sold();
        $sold->fill($production);

        $builder->InitiateExisting($object);
        $builder->BuildStock();
        $soldProduction = $builder->GetProduct();
        if (CheckerService::CheckProductionStock($sold, $soldProduction))
            Sold::create($production);
        else   return \response(['error' => 'Не хватает: ' . $soldProduction->title]);
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
