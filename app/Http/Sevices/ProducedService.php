<?php


namespace App\Http\Sevices;


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
        $Factory = new ProducedFactory();
        $item = $Factory->makeProduction(Produced::class, [
            'user_id' => $data->user_id,
            'product_id' => $data->product_id,
            'date' => $data->date,
            'qty' => $data->qty
        ]);
        $check = CheckerService::CheckMaterials($item);
        if ($check)
            return \response(['error' => 'Не достаточно материалов', 'data' => $check]);
        else $item->save();
        return \response('Data saved', '200');
    }

    public function getProduced()
    {
        return $this->produced->get()->qty;
    }
}
