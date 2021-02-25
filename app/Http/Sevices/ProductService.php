<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\Materialnorm;
use App\Models\Produced;
use App\Models\Product;

class ProductService
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
        $this->produced = new Produced();
    }

    public function get()
    {
        return $this->product->get();
    }

    public function GetProductionNorm($prodID)
    {
        $array = array();

        $AllUsedMaterials = $this->product->find($prodID)->materialNorm()->get();
        $materials = new Material();
        foreach ($AllUsedMaterials as $item) {
            $id = $item->id;
            $title = $materials->find($item->material_id)->title;
            $norma = $item->norma;
            $unit = $materials->find($item->material_id)->unit;
            array_push($array, ['id' => $id,
                'title' => $title,
                'norma' => $norma,
                'unit' => $unit,
                'material_id' => $item->material_id,
                'product_id' => $prodID]);
        }
        return json_encode($array);
    }

    public function EditProductionNorm($normsFromVue)
    {
        $norm = new Materialnorm();
        foreach ($normsFromVue as $item) {
            // проверяем сушествует ли уже норма
            if ($item->id) {
//                если существует, проверяем внесены ли изменения
                if ($norm->find($item->id)->norma != $item->norma) {
//                    если изменения внесены - обновляем запись в БД
                    $norm->find($item->id)->update(['norma' => $item->norma]);
                } //                Если изменений нет, ничего не выполняется
                else echo 'без изменений';
            } else {
                //            если записи не существует - создается новый объект и пишется в бд
                $norm->title = $item->title;
                $norm->material_id = $item->material_id;
                $norm->product_id = $item->product_id;
                $norm->norma = $item->norma;
                $norm->save();
            }
        }
    }

}
