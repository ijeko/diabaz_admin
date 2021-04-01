<?php


namespace App\Http\Sevices;


class ReportsService
{
    public function MonthlyProductionReport($targetMonth, $targetYear, $daysCount, $products)
    {

        $dayProductionReport = [];
        foreach ($products->all() as $product) {
            $daily = [];
            $monthly = $product->produced()
                ->whereYear('date', $targetYear)
                ->whereMonth('date', $targetMonth)
                ->sum('qty');
            for ($day = 1; $daysCount >= $day; $day++) {
                array_push($daily, $product->produced()
                    ->whereYear('date', $targetYear)
                    ->whereMonth('date', $targetMonth)
                    ->whereDay('date', $day)->sum('qty'),
                );
            }
            array_push($dayProductionReport, [
                'id' => $product->id,
                'title' => $product->title,
                'unit' => $product->unit,
                'daily' => $daily,
                'monthly' => $monthly,
            ]);
        }
        return $dayProductionReport;
    }

    public function MonthlyUploadReport($targetMonth, $targetYear, $upload)
    {
        $uploadsData = [];
        $totalSold = [];
        $uploads = $upload->whereYear('date', $targetYear)->whereMonth('date', $targetMonth)->get();
        foreach ($uploads as $upload) {
            $date = $upload->date;
            $qty = $upload->qty;
            $client = $upload->soldTo;
            if ($upload->isMaterial) {
                $product = $upload->material()->first();
            } else {
                $product = $upload->product()->first();

            }
            array_push($uploadsData, [
                'date' => $date,
                'qty' => $qty,
                'client' => $client,
                'title' => $product->title,
                'unit' => $product->unit
            ]);
            array_push($totalSold, [
                'title' => $product->title,
                'totalSold' => $product->getSoldQtyMonthly($targetMonth),
                'unit' => $product->unit
            ]);
        }
        $uploadsData = collect($uploadsData)->sortBy('date', 0, true)->groupBy('date', false);
        $totalSold = collect($totalSold)->sortBy('client')->keyBy('title');
        return ['uploads' => $uploadsData, 'total' => $totalSold];
    }
}
