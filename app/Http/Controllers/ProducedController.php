<?php


namespace App\Http\Controllers;


use App\Http\Sevices\ProducedService;
use App\Models\Produced;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;


class ProducedController extends Controller
{
    private $producedService;
    private $produced;

    public function __construct(ProducedService $producedService, Produced $produced)
    {
        $this->produced = $produced;
        $this->producedService = $producedService;
    }

    public function index(Request $request)
    {
        $data = $request;
        return $this->producedService->get($data);
    }

    public function add(Request $request)
    {
        $data = json_decode($request->data, 1);
        Produced::create($data);

    }
    public function GetAdminProducedItems(Request $request)
    {
        $date = $request->date;
        $product_id = $request->product;
        return $this->producedService->GetPerMonth($date, $product_id);
    }

}
