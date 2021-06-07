<?php


namespace App\Http\Services;


use App\Builders\MaterialBuilder;
use App\Builders\ProductBuilder;
use App\Exceptions\OutOfStockException;
use App\Factories\ProducedFactory;
use App\Models\Produced;
use App\Models\Product;
use http\Client\Response;

class ProducedService extends Service
{
    private $produced;

    public function __construct()
    {
        $this->produced = new Produced();
        $this->materials = new MaterialService();
        $this->product = new Product();
    }

    public function get($data)
    {
        $today = $data->date;
        return $this->produced->where('date', $today)->get();
    }

    public function GetPerMonth($date, $id)
    {
        $Factory = new ProducedFactory();
        $producedItems = $Factory->make(Produced::class);
        $target = $this->ParseDateBy($date);
        return $producedItems
            ->whereYear('date', $target['year'])
            ->whereMonth('date', $target['month'])
            ->where('product_id', $id)
            ->get();
    }

    public function save($data)
    {
        $productBuilder = new ProductBuilder();


        $productBuilder->InitiateExisting(Product::find($data['product_id']));
        $productBuilder->BuildProductWithMaterialNorms();
        $product = $productBuilder->GetProduct();

        $check = CheckerService::CheckMaterialsForProduction($product, $data['qty']);
        if ($check)
        {
            $errorData = json_encode(['error' => 'Не достаточно материалов', 'data' => $check]);
            Throw new OutOfStockException($errorData);
        }

        else {
            Produced::updateOrCreate(['product_id' => $data['product_id'], 'date' => $data['date']], $data);
            return \response('Data saved', '200');
        }

    }

    public function getProduced()
    {
        return $this->produced->get()->qty;
    }
}
