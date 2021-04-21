<?php


namespace App\Http\Sevices;


use App\Builders\BuilderManager;
use App\Builders\ProductBuilder;
use App\Models\Product;

class ReportsService extends Service
{
    public function MonthlyProductionReport()
    {
        $builder = new ProductBuilder();
        $manager = new BuilderManager();
        $manager->SetBuilder($builder);

        $monthlyProductionReport = collect();
        foreach (Product::all() as $product) {
            $manager->MakeProductForMonthlyProductionReport($product);
            $monthlyProductionReport->push($product);
        }
        return $monthlyProductionReport;
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
