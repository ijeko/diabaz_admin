<?php


namespace App\Http\Sevices;


use App\Models\Product;

class ReportsService
{
    public function MonthlyProductionReport($targetMonth, $targetYear, $daysCount, $products, $action)
    {
        $dayProductionReport = [];
//        $products = $this->product->all();
        foreach ($products->all() as $product) {
            $daily = [];
            $client = [];
            $monthly = $product->$action()->sum('qty');
            for ($day = 1; $daysCount >= $day; $day++) {
                if ($product->$action()->getModel()->getConnection()
                    ->getSchemaBuilder()
                    ->hasColumn($product->$action()->getModel()->getTable(), 'soldTo')) {
                    array_push($client,  $product->$action()
                        ->whereYear('date', $targetYear)
                        ->whereMonth('date', $targetMonth)
                        ->whereDay('date', $day)->first());
                }
//                array_push($producedDaily, ['qty' => $product->produced()->whereDay('date', $day)->sum('qty')]);
                array_push($daily, $product->$action()
                    ->whereYear('date', $targetYear)
                    ->whereMonth('date', $targetMonth)
                    ->whereDay('date', $day)->sum('qty'),
                );
//                Проверка, если есть поле soldTO, тогда добавляется контрагент

            }
            array_push($dayProductionReport, [
                'id' => $product->id,
                'title' => $product->title,
                'unit' => $product->unit,
                'daily' => $daily,
                'monthly' => $monthly,
                'upload' => $client
            ]);
//dd($dayProductionReport);
        }
        return $dayProductionReport;
    }
}
