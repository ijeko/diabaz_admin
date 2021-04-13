<?php


namespace App\Builders;


use App\Http\Sevices\DateParser;
use App\Models\Product;

class ProductBuilder implements Builder
{
    protected $product;
    protected $date;

    public function __construct(Product $product)
    {
        $this->reset();
        $this->date = session('currentDate');
        $this->product = $product;
    }

    public function BuildMonthlyIn()
    {
        $date = DateParser::Parse($this->date);
        $monthlyProduction = $this->product->produced()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->sum('qty');
        $this->product->monthlyProduction = $monthlyProduction;
    }

    public function BuildDailyIn()
    {
        $date = DateParser::Parse($this->date);
        $dailyProduction = $this->product->produced()
            ->whereYear('date', $date['year'])
            ->whereMonth('date', $date['month'])
            ->get(['date', 'qty']);
        $this->product->dailyProduction = $dailyProduction->toArray();
    }

    public function BuildMonthlyOut()
    {

    }

    public function BuildDailyOut()
    {

    }

    public function BuildMonthlySpoil()
    {

    }

    public function BuildDailySpoil()
    {

    }

    public function BuildStock()
    {

    }

    public function BuildInstance()
    {

    }

    public function reset(): void
    {
        $this->product = new Product();
    }

    public function getProduct()
    {
        $result = $this->product;
        $this->reset();

        return $result;
    }
}
