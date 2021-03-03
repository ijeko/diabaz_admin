<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'unit', 'name'];

    public function materialNorm ()
    {
        return $this->hasMany(Materialnorm::class);
    }

    public function getProducedQty ()
    {
        $summ = $this->hasMany(Produced::class)->sum('qty');
        return $summ;
    }
}
