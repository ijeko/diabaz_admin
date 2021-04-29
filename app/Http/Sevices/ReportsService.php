<?php


namespace App\Http\Sevices;


use App\Builders\BuilderManager;
use App\Builders\ProductBuilder;
use App\Models\Product;
use Carbon\Carbon;

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

    public function MonthlyUploadReport()
    {
        $builder = new ProductBuilder();
        $manager = new BuilderManager();
        $manager->SetBuilder($builder);

        $monthlyUploadReport = collect();
        $products = collect();
        foreach (Product::all() as $product) {
            $manager->MakeProductionForMonthlyUploadReport($product);
         $products->push($builder->GetProduct());
        }
        $monthlyUploadReport->put('products', $products);
//        dd($monthlyUploadReport
//            ->merge(['dailySolds' => $monthlyUploadReport['products']
//                ->pluck('dailySold')
//                ->flatten()
//                ->groupBy('date', false)]));
        return $monthlyUploadReport
            ->merge(['dailySolds' => $monthlyUploadReport['products']
                ->pluck('dailySold')
                ->flatten()
                ->groupBy('date', false)]);



//
//        $uploadsData = [];
//        $totalSold = [];
//        $uploads = $upload->whereYear('date', $targetYear)->whereMonth('date', $targetMonth)->get();
//        foreach ($uploads as $upload) {
//            $date = $upload->date;
//            $qty = $upload->qty;
//            $client = $upload->soldTo;
//            if ($upload->isMaterial) {
//                $product = $upload->material()->first();
//            } else {
//                $product = $upload->product()->first();
//
//            }
//            array_push($uploadsData, [
//                'date' => $date,
//                'qty' => $qty,
//                'client' => $client,
//                'title' => $product->title,
//                'unit' => $product->unit
//            ]);
//            array_push($totalSold, [
//                'title' => $product->title,
//                'totalSold' => $product->getSoldQtyMonthly($targetMonth),
//                'unit' => $product->unit
//            ]);
//        }
//        $uploadsData = collect($uploadsData)->sortBy('date', 0, true)->groupBy('date', false);
//        $totalSold = collect($totalSold)->sortBy('client')->keyBy('title');
//        return ['uploads' => $uploadsData, 'total' => $totalSold];
    }

    public function YearProductionInTons () {
        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        return ['produced' => $this->ProducedInTons($year, $month), 'sold'=> $this->SoldInTons($year, $month)];
    }
    private function ProducedInTons($year, $month)
    {
        $monthProducedInTons = [];
        for ($i=1; $i<=$month; $i++)
        {
            $monthly = 0;
            foreach (Product::all() as $product) {
                $produced = $product->produced()
                    ->where('product_id', $product->id);
                $producedQty = $produced
                    ->whereYear('date', $year)
                    ->whereMonth('date', $i)
                    ->sum('qty');
                if (isset( $product->materialNorm()->where('product_id', $product->id)->where('material_id', 18)->first()->norma))
                {
                    $mkrNorm = $product->materialNorm()->where('product_id', $product->id)->where('material_id', 18)->first()->norma;
                    $monthly = $monthly + $producedQty * $mkrNorm;
                }
            }
            array_push($monthProducedInTons, $monthly);
        }
        return $monthProducedInTons;
    }
    private function SoldInTons($year, $month)
    {
        $monthSoldInTons = [];
        for ($i=1; $i<=$month; $i++)
        {
            $monthly = 0;
            foreach (Product::all() as $product) {
                $sold = $product->sold()
                    ->where('product_id', $product->id);
                $soldQty = $sold
                    ->whereYear('date', $year)
                    ->whereMonth('date', $i)
                    ->sum('qty');
                if (isset( $product->materialNorm()->where('product_id', $product->id)->where('material_id', 18)->first()->norma))
                {
                    $mkrNorm = $product->materialNorm()->where('product_id', $product->id)->where('material_id', 18)->first()->norma;
                    $monthly = $monthly + $soldQty * $mkrNorm;
                }
            }
            array_push($monthSoldInTons, $monthly);
        }
        return $monthSoldInTons;
    }

}
