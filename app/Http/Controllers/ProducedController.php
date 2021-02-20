<?php


namespace App\Http\Controllers;


use App\Http\Sevices\ProducedService;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;


class ProducedController extends Controller
{
    public function __construct () {
        $this->produced = new ProducedService();
    }
    public function index (Request $request)
    {
        $data = $request;
        return  $this->produced->get($data);
    }
    public function add (Request $request)
    {
        $data = json_decode($request->data);
        $this->produced->save($data);

        return \Illuminate\Http\Response::HTTP_ACCEPTED;
    }

}
