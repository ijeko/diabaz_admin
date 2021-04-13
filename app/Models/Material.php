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
    /**
     * @var string
     */
    private $year;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->isMaterial = 1;
        $this->year = \Carbon\Carbon::now()->format('Y');
    }

    public function norma()
    {
        return $this->hasMany(Materialnorm::class)->get();
    }

    public function getIncomeSumm()
    {
        $summ = $this->hasMany(MaterialIncome::class)->sum('qty');
        return $summ;
    }

    public function getMonthlyIncomeSumm($month)
    {
        $summ = $this->hasMany(MaterialIncome::class)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $month)
            ->sum('qty');
        return $summ;
    }


    public function getSoldQty()
    {
        $total = $this->hasMany(Sold::class, 'product_id')->get()
            ->where('isMaterial', 1);
        $summ = $total->sum('qty');
        return $summ;
    }

    public function getSoldQtyMonthly()
    {
        $month = \Carbon\Carbon::now()->format('m');
        $monthly = $this->hasMany(Sold::class, 'product_id')
            ->whereMonth('date', $month)
            ->get();
        $summ = $monthly
            ->where('isMaterial', 1)
            ->sum('qty');
        return $summ;
    }

    public function inStock()
    {
        return $this->getIncomeSumm() - $this->getSoldQty() - $this->used();
    }

    public function used()
    {
        $used = 0;
        foreach ($this->norma() as $norma) {
            $used = $used + Produced::where('product_id', $norma->product_id)->sum('qty') * $norma->norma;
        }
        return $used;
    }
}
