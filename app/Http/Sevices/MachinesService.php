<?php


namespace App\Http\Sevices;


use App\Models\Machine;
use Illuminate\Http\Response;

class MachinesService
{
    private $machine;

    public function __construct()
    {
        $this->machine = new Machine();
    }

    public function get()
    {
        return $this->machine->get();
    }


    public function EditMachine($data)
    {
        $records = $this->machine->find($data->id);

        $records->update(['title' => $data->title, 'name' => $data->name, 'unit' => $data->unit]);
    }


    public function newMachine($data)
    {
        if ($this->machine->where('title', $data->title)->exists()) {
            return response()->
            json([
                'name' => '',
                'title' => 'Значение уже используется'
            ]);
        }
        if ($this->machine->where('name', $data->name)->exists()) {
            return response()->
            json([
                'name' => 'Значение уже используется',
                'title' => ''
            ]);
        }else {
            $this->machine->title = $data->title;
            $this->machine->name = $data->name;
            $this->machine->unit = $data->unit;
            $this->machine->save();
            return Response::HTTP_OK;
        }
    }

}
