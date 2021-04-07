<?php


namespace App\Http\Sevices;


use App\Factories\ModelFactory;
use App\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Service
{
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
