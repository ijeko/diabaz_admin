<?php

namespace App\Http\Controllers;

use App\Http\Sevices\MotohoursService;
use App\Http\Sevices\ProducedService;
use Illuminate\Http\Request;

class MotohoursController extends Controller
{
    //
    public function __construct () {
        $this->motohours = new MotohoursService();
    }
    public function index (Request $request)
    {
        $data = $request;
        return  $this->motohours->get($data);
    }
    public function add (Request $request)
    {
        $data = json_decode($request->data);
        $this->motohours->save($data);

        return \Illuminate\Http\Response::HTTP_ACCEPTED;
    }
}
