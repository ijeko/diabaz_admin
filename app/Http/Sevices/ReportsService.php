<?php


namespace App\Http\Sevices;


use App\Models\Product;

class ReportsService
{
    public function MonthlyProductionReport($targetMonth, $targetYear, $daysCount, Product $products)
    {
        $dayProductionReport = [];
//        $products = $this->product->all();
        foreach ($products->all() as $product) {
            $producedDaily = [];
            $producedMonthly = $product->produced()->sum('qty');
            for ($day=1; $daysCount>=$day; $day++) {
//                array_push($producedDaily, ['qty' => $product->produced()->whereDay('date', $day)->sum('qty')]);
                array_push($producedDaily, $product->produced()
                    ->whereYear('date', $targetYear)
                    ->whereMonth('date', $targetMonth)
                    ->whereDay('date', $day)->sum('qty'));

            }
            array_push($dayProductionReport, [
                'id' => $product->id,
                'title' => $product->title,
                'unit' => $product->unit,
                'daily' => $producedDaily,
                'monthly' => $producedMonthly
            ]);

        }
        return $dayProductionReport;
    }
}
