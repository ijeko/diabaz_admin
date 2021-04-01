<?php


namespace App\Http\Sevices;


use App\Factories\ProducedFactory;
use App\Factories\ProductFactory;
use App\Factories\SoldFactory;
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
        $time = strtotime($date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $products = [];
        foreach ($this->product->get() as $product) {
            array_push($products, [
                'id' => $product->id,
                'title' => $product->title,
                'name' => $product->name,
                'totalProduced' => $product->getProducedQty(),
                'dayProduced' => $product->produced()
                    ->whereYear('date', $targetYear)
                    ->whereMonth('date', $targetMonth)
                    ->sum('qty'),
                'sold' => $product->getSoldQtyMonthly($targetMonth),
                'stock' => round($product->getProducedQty() - $product->getSoldQty() - $this->asMaterial($product->id), 2),
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

        $Factory = new ProductFactory();
        $model = $Factory->make(Product::class, $data);
        $check = CheckerService::CheckExists($model);
        if ($check) return $check;
        else $model->save();
        return Response::HTTP_OK;
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

//    public function AddSold($data)
//    {
//        $Factory = new SoldFactory();
//        $item = $Factory->make(Sold::class, $data);
//        $check = CheckerService::CheckProductionStock($item);
//        if ($check) $item->save();
//        else   return \response(['error' => 'Не достаточно продукции: ' . $item->product()->first()->title]);
//
//    }

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


    public function GetPerMonth($year, $month, $process, $id)
    {
        $Factory = new ProducedFactory();
        $model = $Factory->makeAnyModel($process);
        return $model
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('product_id', $id)
            ->get();
    }
}
