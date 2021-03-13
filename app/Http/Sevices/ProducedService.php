<?php


namespace App\Http\Sevices;


use App\Models\Produced;

class ProducedService
{
    private $produced;

    public function __construct()
    {
        $this->produced = new Produced();
    }

    public function get($data)
    {
        $today = $data->date;
        return $this->produced->where('date', $today)->get();
    }

    public function save($data)
    {
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

    public function getProduced()
    {
        return $this->produced->get()->qty;
    }
}
