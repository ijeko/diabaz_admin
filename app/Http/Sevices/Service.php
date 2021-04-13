<?php


namespace App\Http\Sevices;


use App\Builders\BuilderManager;
use App\Builders\ProductBuilder;
use App\Factories\ModelFactory;

abstract class Service
{


    public function __construct ()
    {
    }

    public function Remove($model, $id)
    {
        $Factory = new ModelFactory();
        $Factory->makeAnyModel($model)->destroy($id);
        return \response('Data deleted', '200');
    }

    protected function ParseDateBy($date)
    {
        $time = strtotime($date);
        $targetDay = date('d', $time);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        return [
            'day' => $targetDay,
            'month' => $targetMonth,
            'year' => $targetYear
        ];
    }
}
