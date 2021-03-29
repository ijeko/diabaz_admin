<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'unit', 'name', 'minQty'];
    public $isMaterial;
    private $title;
    private $unit;
    private $name;
    private $qty;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->isMaterial = 1;
    }

    public function norma()
    {
//        dd(__METHOD__, $this->hasMany(Materialnorm::class)->get());
        return $this->hasMany(Materialnorm::class)->get();
    }

    public function getIncomeSumm()
    {
        $summ = $this->hasMany(MaterialIncome::class)->sum('qty');
        return $summ;
    }

    public function minimum()
    {
        return $this->hasOne(MaterialMinimum::class);
    }

    public function getSoldQty()
    {
        $summ = $this->hasMany(Sold::class, 'product_id')->where('isMaterial', 1)->sum('qty');
        return $summ;
    }

    public function inStock()
    {
        $used = 0;
        foreach (Materialnorm::all()->where('material_id', $this->id) as $product) {

            $used = $used + Produced::whereProductId($product->product_id)->sum('qty') * $product->norma;
        }
        return $this->getIncomeSumm() - $this->getSoldQty() - $used;
    }
}
