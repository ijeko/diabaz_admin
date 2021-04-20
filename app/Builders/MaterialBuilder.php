<?php


namespace App\Builders;


use App\Http\Sevices\DateParser;
use App\Models\Material;
use App\Models\Produced;
use Illuminate\Database\Eloquent\Model;

class MaterialBuilder implements Builder
{
    protected $material;
    protected $date;

    public function __construct()
    {
        $this->reset();
        $this->date = session('currentDate');
        $this->date = DateParser::Parse($this->date);
    }

    public function InitiateExisting(Model $object)
    {
        $this->material = $object;
    }

    public function BuildMonthlyIn()
    {
        $monthlyIncome = $this->material->incomes()
            ->whereYear('date', $this->date['year'])
            ->whereMonth('date', $this->date['month'])
            ->sum('qty');
        $this->material->monthlyIncome = round($monthlyIncome, 2);
    }

    public function BuildDailyIn()
    {
        $dailyPIncome = $this->material->incomes()
            ->whereYear('date', $this->date['year'])
            ->whereMonth('date', $this->date['month'])
            ->get(['id', 'date', 'qty']);
        $this->material->dailyIncome = $dailyPIncome;
    }

    public function BuildMonthlyOut()
    {
        $monthlySold = $this->material->sold()
            ->whereYear('date', $this->date['year'])
            ->whereMonth('date', $this->date['month'])
            ->where('isMaterial', 1)
            ->sum('qty');
        $this->material->monthlySold = round($monthlySold, 2);
        $usageNorms = $this->material->norma()->get();
        $monthlyUsed = 0;
        foreach ($usageNorms as $norma) {
            $monthlyUsed = $monthlyUsed + Produced::where('product_id', $norma->product_id)
                    ->whereYear('date', $this->date['year'])
                    ->whereMonth('date', $this->date['month'])
                    ->sum('qty') * $norma->norma;
        }
        $this->material->monthlyUsed = round($monthlyUsed, 2);
    }

    public function BuildDailyOut()
    {
        $dailySold = $this->material->sold()
            ->whereYear('date', $this->date['year'])
            ->whereMonth('date', $this->date['month'])
            ->where('isMaterial', 0)
            ->get(['id', 'date', 'qty']);
        $this->material->dailySold = $dailySold;
        $produceActions = Produced::all()
            ->whereYear('date', $this->date['year'])
            ->whereMonth('date', $this->date['month'])
            ->get();
        $dayUsed = collect();
        foreach ($produceActions as $produced) {
            $norma = $this->material
                ->norma()
                ->where('product_id', $produced->product_id)
                ->first()
                ->norma;
            $dayUsed->push(['date' => $produced->date, 'qty' => $produced->qty * $norma]);
        }
        $this->material->dailyUsed = $dayUsed;
    }

    public function BuildStock()
    {
        $income = $this->material->incomes()->sum('qty');

        $usageNorms = $this->material->norma()->get();
        $used = 0;
        foreach ($usageNorms as $norma) {
            $used = $used + Produced::where('product_id', $norma->product_id)
                    ->sum('qty') * $norma->norma;
        }

        $sold = $this->material->sold()->where('isMaterial', 1)->sum('qty');

        $inStock = $income - $sold - $used;
        $this->material->stock = round($inStock, 2);
    }

    public function BuildDailySpoil()
    {
        // TODO: Implement BuildMonthlySpoil() method.

    }

    public function BuildMonthlySpoil()
    {
        // TODO: Implement BuildMonthlySpoil() method.
    }

    public function reset(): void
    {
        $this->material = new Material();
    }

    public function GetProduct()
    {
        $result = $this->material;
        $this->reset();

        return $result;
    }
}
