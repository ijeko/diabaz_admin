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
    public function index ()
    {
        return view('reports');
    }

    public function test ()
    {

        $products=$this->product->all();
        foreach ($products as $product)
        {

        }
        dd(__METHOD__, $products->whereDay('date', 9)->get());
    }
}
