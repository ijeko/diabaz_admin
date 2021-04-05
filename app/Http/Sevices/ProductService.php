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

    public function Get($date)
    {
        $time = strtotime($date);
        $targetMonth = date('m', $time);
        $targetYear = date('Y', $time);
        $products = [];
        foreach ($this->product->all() as $product) {
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

    public function GetMaterialsNormsOf(Product $product)
    {
        $materialsForProduct = array();
        $usedMaterialsNorms = $product->materialNorm()->get();
        foreach ($usedMaterialsNorms as $usedMaterialNorma) {
            $id = $usedMaterialNorma->id;
            $title = $usedMaterialNorma->title;
            $norma = $usedMaterialNorma->norma;
            $unit = $usedMaterialNorma->material()->first()->unit;
            array_push($materialsForProduct, [
                'id' => $id,
                'title' => $title,
                'norma' => $norma,
                'material_id' => $usedMaterialNorma->material_id,
                'product_id' => $usedMaterialNorma->product_id,
                'unit' => $unit,
            ]);
        }
        return json_encode($materialsForProduct);
    }

    public function EditProduct($data)
    {
        $records = $this->product->find($data->id);

        $records->update(['title' => $data->title, 'name' => $data->name, 'unit' => $data->unit]);
    }

    public function EditMaterialsNormFor($changedNorm)
    {
        $now = Carbon::now();
        $newNorms = [];
//        $norm = new Materialnorm();
        foreach ($changedNorm->get() as $norm) {
            // проверяем сушествует ли уже норма
            if ($norm->exists()) {
                dd(__METHOD__);
                $norm->update();
            } else {
                //            если записи не существует - создается новый объект и пишется в бд
                $newNorms[] = [
                    'title' => $normm->title,
                    'product_id' => $norm->product_id,
                    'material_id' => $norm->material_id,
                    'norma' => $norm->norma,
//                    'created_at' => $now,
//                    'updated_at' => $now
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
