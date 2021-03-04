<?php

namespace App\Http\Controllers;

use App\Http\Sevices\MachinesService;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    //
    public function __construct()
    {
        $this->machines = new MachinesService();
    }

    public function index()
    {

        return $this->machines->get()->toJson();;
    }

    public function ShowNorm(Request $request)
    {
        return response($this->machines->GetMachineNorm($request->id));

    }

    public function EditNorm(Request $request)
    {
        return $this->machines->EditMachineNorm(json_decode($request->data));
    }

    public function Edit(Request $request)
    {
        return $this->machines->EditMachine(json_decode($request->data));
    }

    public function RemoveNorm(Request $request)
    {
        $model = new MachineNorm();
        $norm = $model->find($request->id);
        if ($norm) {
            $norm->delete();
        }
        echo 'Nothing to delete';
    }

    public function Remove(Request $request)
    {
        $model = new Machine();
        $machine = $model->find($request->id);
        if ($machine) {
            $machine->delete();
        }
        echo 'Nothing to delete';
    }
    public function Add (Request $request)
    {
        return $this->machines->newMachine(json_decode($request->data));
    }

}
