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
    private $product;

    public function __construct()
    {
        $this->material = new Material();
        $this->product = new Product();
        $this->produced = new Produced();
        $this->sold = new Sold();
        $this->norm = new Materialnorm();
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

    public function EditProduct($data)
    {
//        dd($data);
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
//            if ($item->id) {
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
//                $norm->fill();
//                $norm->save($newNorms);
//                $norm->title = $item->title;
//                $norm->product_id = $item->product_id;
//                $norm->material_id = $item->material_id;
//                $norm->norma = $item->norma;

//                $norm->save();
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
//            return response()->json([
//                'name' => '',
//                'title' => '',
//                'message' => 'OK'
//            ]);
        }
    }

    public function getSold($data)
    {
        $today = $data->date;

        foreach ($this->product->all() as $product) {
            $productSold = $this->sold->where('date', $today)->where('product_id', $product->id)->get()->sum('qty');
//            $product = $this->product->find($id);
            $sold[]=['product_id' => $product->id, 'qty' => $productSold];
        }

//dd($sold);
        return response()->
        json($sold);
//
////        dd();
//        return $this->sold->where('date', $today)->get()->sum('qty');
    }

    public function AddSold($data)
    {
//        if ($this->sold->where('date', $data->date)->exists() && $this->sold->where('product_id', $data->product_id)->exists()) {
//            dd('exists');
//            $records = $this->sold->where('date', $data->date)->get();
//            $record_id = $records->where('product_id', $data->product_id)->first()->id;
//            $this->sold->where('id', $record_id)->update(['qty' => $data->qty, 'user_id' => $data->user_id]);
//        } else {
            $this->sold->user_id = $data->user_id;
            $this->sold->product_id = $data->product_id;
            $this->sold->qty = $data->qty;
            $this->sold->date = $data->date;
            $this->sold->soldTo = $data->soldTo;
            $this->sold->save();
//        }
    }

    public function Stock()
    {

        foreach ($this->product->all() as $product) {
            $asMaterial = 0;
            foreach ($this->material->all() as $material)
            {
                if ($product->name === $material->name) {
//                    $CurrentMatNorm = $this->norm->where('material_id', $material->id)->get();
                    $asMaterial =
//                        $this->ProductAsMaterialQty($CurrentMatNorm) +
                        $material->getIncomeSumm();
//                    $asMaterial = $product->getProducedQty()*$this->norm->where('product_id', $material->id)->where('product_id', $material->id)->get()->norma;

                }
            }
//            $product = $this->product->find($id);
            $productStock = $product->getProducedQty() - $product->getSoldQty() - $asMaterial;
            $stock[]=['product_id' => $product->id, 'qty' => $productStock];

    }
        return response()->
        json($stock);
    }

//    private function ProductAsMaterialQty ($asMaterial) {
//        $qty = 0;
//        foreach ($asMaterial as $item)
//        {
//            $qty = $qty + ($item->norma * $this->product->find($item->product_id)->getProducedQty());
//        }
////        dd($qty);
//        return $qty;
//    }

}
