<?php

namespace App\Http\Controllers;

use App\Http\Services\ReportsService;
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
        return $this->reportsService->MonthlyProductionReport();
    }

    public function MonthlyUploadReport()
    {
        return $this->reportsService->MonthlyUploadReport();
    }

    public function YearlyProductionInTonsReport ()
    {
        $response =  $this->reportsService->YearProductionInTons();
        return $response;
    }
}
