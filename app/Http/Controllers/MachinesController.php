<?php

namespace App\Http\Controllers;

use App\Http\Sevices\MachinesService;
use App\Models\Machine;
use App\Models\Motohour;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    private $machine;
    private $machineService;

    public function __construct(Machine $machine, MachinesService $machineService)
    {
        $this->machine = $machine;
        $this->machineService = $machineService;
    }

    public function GetMachineListWithMonthUsage(Request $request)
    {
        $date = $request->date;
        return $this->machineService->GetMachinesWithUsageOn($date);
    }

    public function AddNewMachine(Request $request)
    {
        $attributes = json_decode($request->data, 1);
        return $this->machineService->AddNewMachineWith($attributes);
    }

    public function EditMachine(Request $request)
    {
        $newAttributes = json_decode($request->data, 1);
        return $this->machineService->SaveMachineWith($newAttributes);
    }


    public function Remove(Request $request)
    {
        $machine = $request->data;
        Machine::destroy($machine);
    }

    public function AddUsage(Request $request)
    {
        $usage = json_decode($request->data, 1);
        Motohour::create($usage);
    }
}
