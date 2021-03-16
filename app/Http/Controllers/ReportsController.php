<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialIncome;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->material = new Material();
        $this->product = new Product();
    }

    public function index()
    {
        return view('reports');
    }

    public function test(Request $request)
    {

        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $daysCount = $request->days;
        $dayProductionReport = [];
        $products = $this->product->all();
        foreach ($products as $product) {
            $producedDaily = [];
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
                'daily' => $producedDaily
            ]);

        }
        return $dayProductionReport;
    }
}
