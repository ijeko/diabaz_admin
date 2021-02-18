<?php


namespace App\Http\Sevices;


use App\Models\Material;

class MaterialService
{
    private $material;
    public function __construct(Material $material)
    {
        $this->material=$material;
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
