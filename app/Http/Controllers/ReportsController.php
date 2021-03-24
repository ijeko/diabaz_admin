<?php

namespace App\Http\Controllers;

use App\Http\Sevices\ReportsService;
use App\Models\Material;
use App\Models\Product;
use App\Models\Sold;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->reports = new ReportsService();
        $this->material = new Material();

    }

    public function index()
    {
        return view('reports');
    }

    public function MonthlyReport(Request $request)
    {
        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $daysCount = $request->days;
        return $this->reports->MonthlyProductionReport($targetMonth, $targetYear, $daysCount, new Product());
    }

    public function UploadReport(Request $request)
    {
        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        return $this->reports->MonthlyUploadReport($targetMonth, $targetYear, new Sold());
    }
}
