<?php


namespace App\Builders;


use App\Builders\BuilderInterfaces\Builder;

class BuilderManager
{
    protected $builder;

    public function SetBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    public function MakeProductsForDashboard ($product)
    {
        $this->builder->InitiateExisting($product);
        $this->builder->BuildMonthlyIn();
        $this->builder->BuildMonthlyOut();
        $this->builder->BuildStock();
    }

    public function MakeProductForAdminDashboard ($product)
    {
        $this->builder->InitiateExisting($product);
        $this->builder->BuildDailyIn();
        $this->builder->BuildDailySpoil();
        $this->builder->BuildDailyOut();
    }

    public function MakeProductForMonthlyProductionReport($product)
    {
        $this->builder->InitiateExisting($product);
        $this->builder->BuildDailyIn();
        $this->builder->BuildMonthlyIn();
        $this->builder->BuildMonthlySpoil();
    }

    public function MakeProductionForMonthlyUploadReport($product)
    {
        $this->builder->InitiateExisting($product);
        $this->builder->BuildDailyOut();
        $this->builder->BuildMonthlyOut();

    }
}
