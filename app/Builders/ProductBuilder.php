<?php


namespace App\Builders;


use App\Http\Sevices\DateParser;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductBuilder implements Builder
{
    protected $product;
    protected $date;

    public function __construct()
    {
        $this->reset();
        $this->date = session('currentDate');
    }

    public function InitiateExisting(Model $object)
    {
        $this->product = $object;
    }

    public function BuildMonthlyIn()
    {
        $date = DateParser::Parse($this->date);
        $monthlyProduction = $this->product->produced()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->sum('qty');
        $this->product->monthlyProduction = round($monthlyProduction, 2);
    }

    public function BuildDailyIn()
    {
        $date = DateParser::Parse($this->date);
        $dailyProduction = $this->product->produced()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->get(['date', 'qty']);
        $this->product->dailyProduction = round($dailyProduction, 2);
    }

    public function BuildMonthlyOut()
    {
        $date = DateParser::Parse($this->date);
        $monthlySold = $this->product->sold()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->where('isMaterial', 0)
            ->sum('qty');
        $this->product->monthlySold = round($monthlySold, 2);
    }

    public function BuildDailyOut()
    {
        $date = DateParser::Parse($this->date);
        $dailySold = $this->product->sold()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->where('isMaterial', 0)
            ->get(['date', 'qty']);
        $this->product->dailySold = round($dailySold, 2);
    }

    public function BuildMonthlySpoil()
    {
        $date = DateParser::Parse($this->date);
        $monthlySpoiled = $this->product->Spoiled()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->sum('qty');
        $this->product->monthlySpoiled = round($monthlySpoiled, 2);
    }

    public function BuildDailySpoil()
    {
        $date = DateParser::Parse($this->date);
        $dailySpoiled = $this->product->Spoiled()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->get(['date', 'qty']);
        $this->product->dailySpoiled = round($dailySpoiled, 2);
    }

    public function BuildStock()
    {
        $produced = $this->product->produced()->sum('qty');
        $sold = $this->product->sold()->where('isMaterial', 0)->sum('qty');
        $spoiled = $this->product->Spoiled()->sum('qty');
        $inStock = $produced - $sold - $spoiled;
        $this->product->stock = round($inStock, 2);
    }

    public function BuildProductWithMaterialNorms()
    {
        $usedMaterials = $this->product->materialNorm();
        $materialsAndNorms = collect();
        foreach ($usedMaterials->get() as $usedMaterial) {
            $materialsAndNorms->push([
                'title' => $usedMaterial->material()->first()->title,
                'norma' => $usedMaterial->norma,
                'unit' => $usedMaterial->material()->first()->unit
            ]);
        }
        $this->product->materialsNorms = $materialsAndNorms;
    }

    public function BuildProductWithUsedMaterials()
    {

    }

    public function reset(): void
    {
        $this->product = new Product();
    }

    public function GetProduct()
    {
        $result = $this->product;
        $this->reset();

        return $result;
    }
}
