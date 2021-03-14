<?php


namespace App\Http\Sevices;


use App\Models\Produced;
use App\Models\Product;
use http\Client\Response;

class ProducedService
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

    public function save($data)
    {
        $toCheck = $this->product->find($data->product_id)->materialNorm()->get();
        if ($this->materials->chekInStock($toCheck, $data) != null) {
            $response = $this->materials->chekInStock($toCheck, $data);
           return json_encode($response);
    }
        else {
        if ($this->produced->where('date', $data->date)->where('product_id', $data->product_id)->exists()) {
            $records = $this->produced->where('date', $data->date)->get();
            $record_id = $records->where('product_id', $data->product_id)->first()->id;
            $this->produced->where('id', $record_id)->update(['qty' => $data->qty, 'user_id' => $data->user_id]);
        } else {
            $this->produced->user_id = $data->user_id;
            $this->produced->product_id = $data->product_id;
            $this->produced->qty = $data->qty;
            $this->produced->date = $data->date;
            $this->produced->save();
        }
    }
    }

    public function getProduced()
    {
        return $this->produced->get()->qty;
    }
}
