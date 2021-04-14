<?php


namespace App\Builders;


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

}
