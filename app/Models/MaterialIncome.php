<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIncome extends Model
{
    use HasFactory;

    private $year;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->year = \Carbon\Carbon::now()->format('y');
    }

    public function getMonthlyIncomeSumm($month)
    {
        $summ = $this->whereYear('date', $this->year)
            ->whereMonth('date', $month)
            ->sum('qty');
        return $summ;
    }
}
