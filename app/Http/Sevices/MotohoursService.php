<?php


namespace App\Http\Sevices;


use App\Models\Motohour;
use App\Models\Produced;

class MotohoursService
{
    private $motohour;

    public function __construct()
    {
        $this->motohour = new Motohour();
    }

    public function get($data)
    {
        $today=$data->date;
//        $today = date('Y-m-d');
        return $this->motohour->where('date', $today)->get();
//        dd($this->produced->get()->where('date', '=', $today));
//        return $this->produced->all();
    }

    public function save($data)
    {
        if ($this->motohour->where('date', $data->date)->exists() && $this->motohour->where('machine_id', $data->machine_id)->exists())
        {
            $records = $this->motohour->where('date', $data->date)->get();
            $record_id=$records->where('machine_id', $data->machine_id)->first()->id;
            $this->motohour->where('id', $record_id)->update(['qty'=> $data->qty, 'user_id'=>$data->user_id]);
        }
        else {
            $this->motohour->user_id = $data->user_id;
            $this->motohour->machine_id = $data->machine_id;
            $this->motohour->qty = $data->qty;
            $this->motohour->date = $data->date;
            $this->motohour->save();
        }
    }

    public function getProduced ()
    {
        return $this->produced->get()->qty;
    }
}
