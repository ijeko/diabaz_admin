<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function norma ()
    {
//        dd(__METHOD__, $this->hasMany(Materialnorm::class)->get());
        return $this->hasMany(Materialnorm::class)->get();
    }
    public function getIncomeSumm ()
    {
        $summ = $this->hasMany(MaterialIncome::class)->sum('qty');
        return $summ;
    }
}
