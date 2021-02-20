<?php


namespace App\Http\Sevices;


use App\Models\Material;

class MaterialService
{
    public function __construct()
    {
        $this->material=new Material();
    }
    public function getInfo($id, $param)
    {
        $test=$this->material->find($id)->$param;
        return $test;
    }

    public function get ()
    {
        return $this->material->All();
    }

}
