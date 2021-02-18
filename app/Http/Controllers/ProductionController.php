<?php


namespace App\Http\Controllers;


use App\Http\Sevices\ProductService;
use http\Env\Request;
use Illuminate\Http\Response;

class ProductionController extends Controller
{
    public function getProducts()
    {

        return Response::HTTP_ACCEPTED;
    }

}
