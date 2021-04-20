<?php

namespace App\Http\Controllers;

use App\Http\Sevices\ReportsService;
use App\Models\Material;
use App\Models\Product;
use App\Models\Sold;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    protected $reportsService;

    public function __construct(ReportsService $reportsService)
    {
        $this->reportsService = $reportsService;
    }

    public function index()
    {
        return view('reports');
    }

    public function MonthlyProductionReport()
    {
//        $time = strtotime($request->date);
//        $targetMonth = date('m', $time);
//        $targetYear = date('Y', $time);
//        $daysCount = $request->days;
        return $this->reportsService->MonthlyProductionReport();
    }

    public function MonthlyUploadReport(Request $request)
    {
        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        return $this->reports->MonthlyUploadReport($targetMonth, $targetYear, new Sold());
    }
}
