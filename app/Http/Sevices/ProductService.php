<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\Materialnorm;
use App\Models\Produced;
use App\Models\Product;

class ProductService
{
    private $product;
    public function __construct() {
        $this->product=new Product();
        $this->produced = new Produced();
    }

    public function get() {
        return $this->product->get();
    }
    public function GetProductionNorm($prodID)
    {
        $array = array();

        $AllUsedMaterials=$this->product->find($prodID)->materialNorm()->get();
        $materials=new Material();
        foreach ($AllUsedMaterials as $item) {
            $title = $materials->find($item->material_id)->title;
            $norma = $item->norma;
            $unit = $materials->find($item->material_id)->unit;
            array_push($array, ['title' => $title, 'norma' => $norma, 'unit' => $unit]);
        }
       return json_encode($array);
    }

}
