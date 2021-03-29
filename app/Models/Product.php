<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\SafeStorage;

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
    public function getSoldQty ()
    {
        $summ = $this->hasMany(Sold::class)->where('isMaterial', 0)->sum('qty');
        return $summ;
    }
    public function getProducedByDate($today)
    {
        $summ = $this->hasMany(Produced::class)->where('date', $today)->sum('qty');
        return $summ;
    }

    public function inStock()
    {
        return $this->getProducedQty() - $this->getSoldQty();
    }
    public function produced ()
    {
        return $this->hasMany(Produced::class);
    }
//    public function sold ()
//    {
//        return $this->hasMany(Sold::class);
//    }
}
