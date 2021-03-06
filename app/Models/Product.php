<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\SafeStorage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'unit', 'name'];

    public function materialNorm()
    {
        return $this->hasMany(Materialnorm::class, 'product_id');
    }

    public function getProducedQty()
    {
        $summ = $this->hasMany(Produced::class)->sum('qty');
        return $summ;
    }

    public function getSoldQty()
    {
        $total = $this->hasMany(Sold::class, 'product_id')->get()->where('isMaterial', 0);
        $summ = $total->sum('qty');
        return $summ;
    }

    public function getSoldQtyMonthly($month)
    {
        $monthly = $this->hasMany(Sold::class, 'product_id')
            ->whereMonth('date', $month)
            ->get();
        $summ = $monthly
            ->where('isMaterial', 0)
            ->sum('qty');
        return $summ;
    }

    public function getSpoiledQty()
    {
        $total = $this->hasMany(Spoiled::class, 'product_id');
        $summ = $total->sum('qty');
        return $summ;
    }

    public function getSpoiledQtyMonthly($month)
    {
        $monthly = $this->hasMany(Spoiled::class, 'product_id')
            ->whereMonth('date', $month)
            ->get();
        $summ = $monthly->sum('qty');
        return $summ;
    }

    public function getProducedByDate($today)
    {
        $summ = $this->hasMany(Produced::class)->where('date', $today)->sum('qty');
        return $summ;
    }

    public function inStock()
    {
        return $this->getProducedQty() - $this->getSoldQty() - $this->getSpoiledQty();
    }

    public function produced()
    {
        return $this->hasMany(Produced::class, 'product_id');
    }
    public function sold ()
    {
        return $this->hasMany(Sold::class, 'product_id');
    }

    public function Spoiled ()
    {
        return $this->hasMany(Spoiled::class, 'product_id');
    }
}
