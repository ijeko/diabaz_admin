<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'unit', 'name'];

    public function MonthlyUsage ($year, $month)
    {
        $usage = $this->hasMany(Motohour::class, 'machine_id')
        ->whereYear('date',$year)
        ->whereMonth('date', $month);

        return $usage->sum('qty');
    }

    public function Usage()
    {
        $usage = $this->hasMany(Motohour::class, 'machine_id');
        return $usage->sum('qty');
    }
}
