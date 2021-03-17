<?php

namespace App\Http\Controllers;

use App\Http\Sevices\ReportsService;
use App\Models\Material;
use App\Models\MaterialIncome;
use App\Models\Product;
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
        $action = 'produced';
        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $daysCount = $request->days;
        return $this->reports->MonthlyProductionReport($targetMonth, $targetYear, $daysCount, new Product(), $action);
    }

    public function UploadReport(Request $request)
    {
        $action = 'sold';
        $time = strtotime($request->date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $daysCount = $request->days;
        return $this->reports->MonthlyProductionReport($targetMonth, $targetYear, $daysCount, new Product(), $action);
    }
}
