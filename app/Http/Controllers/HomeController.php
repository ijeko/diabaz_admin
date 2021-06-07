<?php

namespace App\Http\Controllers;

use App\Http\Services\MaterialService;
use App\Http\Services\ProducedService;
use App\Http\Services\ProductService;
use App\Models\Material;
use App\Models\Produced;
use App\Models\Product;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Type;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function inputdata()
    {
        return view('inputdata');
    }

    public function admin()
    {
        return view('admin');
    }

    public function reports()
    {
        return view('reports');
    }
}
