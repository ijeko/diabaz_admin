<?php


namespace App\Http\Sevices;


use App\Models\Material;
use App\Models\Materialnorm;
use App\Models\Produced;
use App\Models\Product;
use App\Models\Sold;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ProductService
{

    public function __construct()
    {
        $this->material = new Material();
        $this->product = new Product();
        $this->produced = new Produced();
        $this->sold = new Sold();
        $this->norm = new Materialnorm();
    }

    public function get($date)
    {
        $products = [];
        foreach ($this->product->get() as $product) {
            array_push($products, [
                'id' => $product->id,
                'title' => $product->title,
                'name' => $product->name,
                'totalProduced' => $product->getProducedQty(),
                'dayProduced' => $product->getProducedByDate($date),
                'sold' => $product->getSoldQty(),
                'stock' => $product->getProducedQty() - $product->getSoldQty() - $this->asMaterial($product->id),
                'unit' => $product->unit
            ]);
        }
        return $products;
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

    public function EditProduct($data)
    {
        $records = $this->product->find($data->id);

        $records->update(['title' => $data->title, 'name' => $data->name, 'unit' => $data->unit]);
    }

    public function EditProductionNorm($normsFromVue)
    {
        $now = Carbon::now();
        $newNorms = [];
        $norm = new Materialnorm();
        foreach ($normsFromVue as $item) {
            // проверяем сушествует ли уже норма
            if ($item->id != null) {
//                если существует, проверяем внесены ли изменения
                if ($norm->find($item->id)->norma != $item->norma) {
//                    если изменения внесены - обновляем запись в БД
                    $norm->find($item->id)->update(['norma' => $item->norma]);
                } //                Если изменений нет, ничего не выполняется
            } else {

                //            если записи не существует - создается новый объект и пишется в бд
                $newNorms[] = [
                    'title' => $item->title,
                    'product_id' => $item->product_id,
                    'material_id' => $item->material_id,
                    'norma' => $item->norma,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }

        }

        Materialnorm::insert($newNorms);
    }

    public function newProduct($data)
    {
        if ($this->product->where('title', $data->title)->exists()) {
            return response()->
            json([
                'name' => '',
                'title' => 'Значение уже используется'
            ]);
        }
        if ($this->product->where('name', $data->name)->exists()) {
            return response()->
            json([
                'name' => 'Значение уже используется',
                'title' => ''
            ]);
        } else {
            $this->product->title = $data->title;
            $this->product->name = $data->name;
            $this->product->unit = $data->unit;
            $this->product->save();
            return Response::HTTP_OK;
        }
    }

    public function getSold($data)
    {
        $today = $data->date;

        foreach ($this->product->all() as $product) {
            $productSold = $this->sold->where('date', $today)->where('product_id', $product->id)->get()->sum('qty');
            $sold[] = ['product_id' => $product->id, 'qty' => $productSold];
        }

        return response()->
        json($sold);
    }

    public function AddSold($data)
    {
        $this->sold->user_id = $data->user_id;
        $this->sold->product_id = $data->product_id;
        $this->sold->qty = $data->qty;
        $this->sold->date = $data->date;
        $this->sold->soldTo = $data->soldTo;
        $this->sold->save();
    }

//    public function Stock()
//    {
//
//        foreach ($this->product->all() as $product) {
//            $asMaterial = 0;
//            foreach ($this->material->all() as $material) {
//                if ($product->name === $material->name) {
//                    $asMaterial =
//                        $material->getIncomeSumm();
//
//                }
//            }
//            $productStock = $product->getProducedQty() - $product->getSoldQty() - $asMaterial;
//            $stock[] = ['product_id' => $product->id, 'qty' => $productStock];
//
//        }
//        return response()->
//        json($stock);
//    }
    public function asMaterial($id)
    {
            $asMaterial = 0;
            foreach ($this->material->all() as $material) {
                if ($this->product->find($id)->name === $material->name) {
                    $asMaterial = $material->getIncomeSumm();
                }
            }
           return $asMaterial;
    }
}
