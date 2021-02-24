<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\Materialnorm;

class MaterialService
{
    public function __construct()
    {
        $this->material = new Material();
    }

    public function getInfo($id, $param)
    {
        $test = $this->material->find($id)->$param;
        return $test;
    }

    public function get()
    {
        return $this->material->All();
    }

    public function GetProductionNorm($prodID)
    {
        $matNorm = new Materialnorm();
        $matNorm->product()->get($prodID);
        dd($matNorm);
    }

}
