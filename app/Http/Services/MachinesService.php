<?php


namespace App\Http\Services;


use App\Factories\MachineFactory;
use App\Models\Machine;
use Illuminate\Http\Response;

class MachinesService extends Service
{
    private $machine;

    public function __construct()
    {
        $this->machine = new Machine();
    }

    public function GetMachinesWithUsageOn($date): array
    {
        $target = $this->ParseDateBy($date);
        $machinesData = [];
        foreach (Machine::all() as $machine) {
            array_push($machinesData, [
                'id' => $machine->id,
                'title' => $machine->title,
                'name' => $machine->name,
                'monthUsage' => $machine->MonthlyUsage($target['year'], $target['month']),
                'totalUsage' => $machine->Usage(),
                'unit' => $machine->unit
            ]);
        }
        return $machinesData;
    }

    public function SaveMachineWith($newAttributes)
    {
        return Machine::where('name', $newAttributes['name'])->update($newAttributes);
    }

    public function AddNewMachineWith($attributes)
    {
        $Factory = new MachineFactory();
        $machine = $Factory->make(Machine::class, $attributes);

        if (CheckerService::IsNewAdminItemExits($machine)) {
            return \response(['error' => 'Запись уже существует'], '403');
        } else $machine->save();
        return \response('Запись добавлена', '200');
    }
}
