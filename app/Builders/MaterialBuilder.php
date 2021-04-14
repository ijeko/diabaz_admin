<?php


namespace App\Builders;


use App\Http\Sevices\DateParser;
use App\Models\Material;
use App\Models\Produced;
use App\Models\Product;
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
//            ->where('isMaterial', 1)
            ->sum('qty');
        $this->material->monthlyUsed = round($monthlySold, 2);
        $usageNorms = $this->material->norma();
        $monthlyUsed = 0;
        foreach ($usageNorms as $norma)
        {
            $monthlyUsed = $monthlyUsed + Produced::where('product_id', $norma->product_id)
                    ->whereYear('date', $this->date['year'])
                    ->whereMonth('date', $this->date['month'])
                    ->sum('qty') * $norma->norma;
        }
        $this->material->monthlyUsed = $monthlyUsed;
    }

    public function BuildDailyOut()
    {
        $date = DateParser::Parse($this->date);
        $dailySold = $this->product->sold()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
//            ->where('isMaterial', 0)
            ->get(['id', 'date', 'qty']);
        $this->product->dailySold = $dailySold;
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
            ->get(['id', 'date', 'qty']);
//        dd($dailySpoiled);
        $this->product->dailySpoiled = $dailySpoiled;
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
                'id' => $usedMaterial->id,
                'title' => $usedMaterial->material()->first()->title,
                'product_id' => $this->product->id,
                'material_id' => $usedMaterial->material()->first()->id,
                'norma' => $usedMaterial->norma,
                'unit' => $usedMaterial->material()->first()->unit
            ]);
        }
        $this->product->materialsNorms = $materialsAndNorms;
    }

    public function BuildProductWithUsedMaterials()
    {
        $this->product->usedMaterials = 'Not available';
    }

    public function reset(): void
    {
        $this->product = new Material();
    }

    public function GetProduct()
    {
        $result = $this->material;
        $this->reset();

        return $result;
    }
}
