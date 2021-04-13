<?php


namespace App\Builders;


interface Builder
{
    public function BuildMonthlyIn ();

    public function BuildDailyIn ();

    public function BuildMonthlyOut ();

    public function BuildDailyOut ();

    public function BuildMonthlySpoil ();

    public function BuildDailySpoil ();

    public function BuildStock ();

    public function BuildInstance ();

}
