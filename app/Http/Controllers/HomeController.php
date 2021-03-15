<?php

namespace App\Http\Controllers;

use App\Http\Sevices\MaterialService;
use App\Http\Sevices\ProducedService;
use App\Http\Sevices\ProductService;
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
        $this->material = new MaterialService(new Material());
        $this->produced = new ProducedService(new Produced());
        $this->product = new ProductService(new Product());
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
